<?php

namespace App\Http\Controllers\bari;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB,Auth;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Quotation;
use App\Models\BariOrder;
use App\Models\ProductStock;
use App\Models\BariComponent;
use App\Http\Traits\BariOrderTrait;
class BariOrderController extends Controller
{
   use BariOrderTrait;
    
    public function order(Request $request)
    {
      
       $data=branch_id($request->all());
       //from bariordertrait
        $sr_number=$this->payments();
        if($request->reciept_type=='quotation')
        {  
           //from bariordertrait
           $sr_number=$this->srNumber($sr_number,'QT');
        
        }elseif($request->reciept_type=='challan')
        { 
           //from bariordertrait
            $sr_number=$this->srNumber($sr_number,'CH');
         }elseif($request->reciept_type=='invoice')
         { 
            //from bariordertrait
            $sr_number=$this->srNumber($sr_number,'IN');
         }
        
       $data=array_merge($data,['sr_number'=>$sr_number]);
      DB::transaction(function() use($request,$data)
      { 
        $payment=Payment::create($data);
      
        if(session('bcart'))
        {
          $this->addToOrder($payment);
        }

        if(session('bccart'))
        {
          $this->addToOrderComponent($payment);
        }
        session()->forget('bcart');
        session()->forget('bccart');
      });
           //from bariordertrait
           $payment=$this->payments();

            //from bariordertrait
            $orders=$this->productOrder($payment);
           
            $cart_data=$orders['cart_data'];
            $cart_data2=$orders['cart_data2'];

             $product=[];
              foreach($cart_data as $data)
              {
                $datas=json_decode($data['properties'], true);
   
                foreach($datas as $d)
                {
                     $product[]=Product::Branch()
                           ->where('id',$d['product_id'])
                           ->select('product_name','id')
                           ->get();
                }
               }
              
              $product = array_unique($product);
              
              $success='Payment Completed';
              $session_data=['success'=>$success,'cart_data'=>$cart_data,'payment'=>$payment,'product'=>$product,'cart_data2'=>$cart_data2];
             return response()->json($session_data);
    }

   

    

    function addToOrder($payment)
    {
      foreach(session('bcart') as $details)
       {
           $components= BariComponent::where('bri_product_id',$details['id'])->get();

           // add to order table
            $this->bariOrder($components,$details,$payment);
            
            //manage Stock
            $this->manageStock($components,$details);
        }
    }

    function addToOrderComponent($payment)
    {   
        $properties=[];
        $request=app('request');
        foreach(session()->get('bccart') as $cart)
        {
            
            $properties[]=['product_id'=>$cart['id']];
         $data= BariOrder::create([

                'description'=>$cart['name'],
                'size'=>preg_replace('/[^0-9]/', '', $cart['name']),
                 'properties'=>json_encode($properties),
                'price'=>$cart['price'],
                'shelf_quentity'=>$cart['quantity'],
                'component'=>$cart['id'],
                'product_quality'=>$cart['qualities'],
                'category_id'=>$cart['category_id'],
                'payment_id' =>$payment['id'],
              ]);
             
          
            // this function manage stock for component
            $this->manageStock2($cart);
        }
    }

    
   
   function bariOrder($components,$details,$payment)
   {
    
    $properties=[];
   
     foreach($components as $component)
       {
          $properties[]=['q'=>$component['bri_quentity'],'name'=>$component['category_name'],'product_id'=>$component['product_id']];
         
      }

      $this->orderNow($details,$properties,$payment);
   }


   function orderNow($details,$properties,$payment)
   {

     $request=app('request');
     BariOrder::create([

           'description'=>$details['name'],
           'size'=>$details['size'],
            'properties'=>json_encode($properties),
           'price'=>$details['price'],
           'shelf_quentity'=>$details['quantity'],
           'category_id'=>$details['category_id'],
           'component'=>null,
           'payment_id' =>$payment['id'],
        ]);
       
   }



  function manageStock($components,$details)
  {
     foreach($components as $component)
     {
        // get product id with this function from product mofdel
         $product=Product::productId($component['product_id']);
         // get stock data with this function from ProductStock Model
         $stock=ProductStock::stockManage($product['id']);
       
         //manage Stock here
         $stock->stock=$stock->stock-($component['bri_quentity']*$details['quantity']);
         $stock->stock_sold=$stock->stock_sold+($component['bri_quentity']*$details['quantity']);
         $stock->save();
       
      }
    }


  //this function mange stock for product component
    function manageStock2($component)
    {
       // from product model
       $product=Product::productId($component['id']);
        //from productstock model 
       $stock=ProductStock::stockManage($product['id']);

       $stock->stock=$stock->stock-$component['quantity'];
       $stock->stock_sold=$stock->stock_sold+$component['quantity'];
       $stock->save();
     }


}
