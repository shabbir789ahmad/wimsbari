<?php

namespace App\Http\Controllers\bari;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB,Auth;
use App\Models\Product;
use App\Models\Payment;
use App\Models\BariOrder;
use App\Models\ProductStock;
use App\Models\BariComponent;
class BariOrderController extends Controller
{
    public function order(Request $request)
    {
      $data=branch_id($request->all());
     
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

           $payment=Payment::Branch()
                    ->latest()
                    ->select('id','paying_amount','discount','tax')
                    ->first();
            $cart_data=BariOrder::
                   where('payment_id',$payment['id'])
                  ->latest()
                  ->whereNull('component')
                  ->get();
                   $cart_data2=BariOrder::
                   where('payment_id',$payment['id'])
                  ->latest()
                  ->whereNotNull('component')
                  ->get();
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
       
            $order= BariOrder::create([

                'description'=>$cart['name'],
                'size'=>preg_replace('/[^0-9]/', '', $cart['name']),
                 'properties'=>json_encode($properties),
                'price'=>$cart['price'],
                'shelf_quentity'=>$cart['quantity'],
                'component'=>$cart['id'],
                'payment_id' =>$payment['id'],
              ]);

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

      $order= BariOrder::create([

           'description'=>$details['name'],
           'size'=>$details['size'],
            'properties'=>json_encode($properties),
           'price'=>$details['price'],
           'shelf_quentity'=>$details['quantity'],
           'component'=>null,
           'payment_id' =>$payment['id'],
        ]);
   }


    function manageStock($components,$details){

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


    function manageStock2($component){

       
         $product=Product::
         join('product_brands','products.id','=','product_brands.product_id')
         ->select('product_brands.id')
         ->where('products.id',$component['id'])
         ->first();

         $stock=ProductStock::
         where('pbrand_id',$product['id'])
         ->first();

         $stock->stock=$stock->stock-$component['quantity'];
         $stock->stock_sold=$stock->stock_sold+$component['quantity'];
         $stock->save();
       

        
    }


}
