<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Brand;
use App\Models\Account;
use App\Http\Traits\QuantityConverter;
use DB;
use Auth;
use App\Http\Traits\OrderTrait;
use App\Http\Traits\CalculateStock;
class OrderController extends Controller
{

  use QuantityConverter;
  use OrderTrait;
  use CalculateStock;
  
 

function order(Request $req)
{
  $id=$req->id;
  $product = Product::
   join('product_brands','products.id','=','product_brands.product_id')
   ->select('products.product_name','product_brands.product_id','products.sell_by','product_brands.id','products.unit_id','products.gst_tax','products.pack_quentity','products.product_code','products.unit_barcode')
   ->where('product_brands.id',$req->brand_id)
   ->Branch()
   ->first();
      
   $stock=ProductStock::where('pbrand_id',$req->brand_id)->where('active','1')->where('stock','>',0)->Branch()->first();
   
    if($product)
    {
      $sell=$req->sell_by;

      $price='';
      $price2='';
      $sell_type='';
      $count=1;
      $quentity_in_kg='';
      $quentity_in_fit='';
      $new_q_fit='';
      $new_q_kg='';
      $vat='';
      $st=$stock['stock'] ;
      
      if($sell== 'piece')
      {

        $st=$st * $stock['pack_quentity'];
        
        if($stock['stock'] < $req->quentity_kg )
        {
            $cart=session()->get('cart');
            return response()->json(['data'=>$cart,'fail'=>'Total'.''.$st.'product left']);
        }else
        {
           $dds= $this->setPrice($req->sell_type,$req->wholesale_one,$stock,$product['gst_tax']);
             $price=$dds['price'];
             $price2=$dds['price2'];
             $sell_type=$dds['sell_type'];
             $vat=$dds['vat_tax'];
         
              //sell type retail if end
        }
      
      }else if($sell == 'unit')
      {
          
        $quentity_in_kg=$this->calculatestock($product['pack_quentity'],$req->quentity_kg,$id);
             $quentity_in_kg=$req->quentity_kg + $quentity_in_kg;

            //total stock left
            $order_quentity=$this->totalQuentityLeft($product['pack_quentity'],$stock['stock'],$stock['stock_sold_kg']);

    
        if($order_quentity < $quentity_in_kg )
        {
            $cart=session()->get('cart');
            return response()->json(['data'=>$cart,'fail'=>'Total'.''.$st.'product left']);
        }else
        {
            $dds= $this->setPrice2($req->sell_type,$req->wholesale_one,$stock,$product['gst_tax'],$req->quentity_kg,$product['pack_quentity']);
            $price=$dds['price'];
            $price2=$dds['price2'];
            $sell_type=$dds['sell_type'];
            $vat=$dds['vat_tax'];
        }
                
      }else if($sell == 'piece, unit' || $sell == 'piece,unit')
      {

        if($req->barcode==$product['product_code'])
        {
           $sell='piece';

           $quentity_in_kg=$this->calculatestock($product['pack_quentity'],$req->quentity_kg,$id);
           
           //sold + requested quentity
             $quentity_in_kg=($req->quentity_kg * $product['pack_quentity']) + $quentity_in_kg;
            
            //total stock left
            $order_quentity=$this->totalQuentityLeft($product['pack_quentity'],$stock['stock'],$stock['stock_sold_kg']);

         if($order_quentity < $quentity_in_kg)
         {
               $cart=session()->get('cart');
               return response()->json(['data'=>$cart,'fail'=>'Total'.''.$st.'product left']);
         }else
         {
            $dds= $this->setPrice($req->sell_type,$req->wholesale_one,$stock,$product['gst_tax']);
             $price=$dds['price'];
             $price2=$dds['price2'];
             $sell_type=$dds['sell_type'];
             $vat=$dds['vat_tax'];
              //sell type retail if end
          }

       }else if($req->barcode==$product['unit_barcode'])
       {
            $sell='unit';
            

            //from calculate trait
            $quentity_in_kg=$this->calculatestock($product['pack_quentity'],$req->quentity_kg,$id);
             $quentity_in_kg=$req->quentity_kg + $quentity_in_kg;
           
            //total stock left
            $order_quentity=$this->totalQuentityLeft($product['pack_quentity'],$stock['stock'],$stock['stock_sold_kg']);
            
            if($order_quentity < $quentity_in_kg)
            {
               $cart=session()->get('cart');
               return response()->json(['data'=>$cart,'fail'=>'Total'.''.$st.'product left']);
            }else
            {
               $price_by_unit= $this->setPrice2($req->sell_type,$req->wholesale_one,$stock,$product['gst_tax'],$req->quentity_kg,$product['pack_quentity']);
               $price=$price_by_unit['price'];
               $price2=$price_by_unit['price2'];
               $sell_type=$price_by_unit['sell_type'];
               $vat=$price_by_unit['vat_tax'];
            }
                
       

       }

         

       }

          

        $cart = session()->get('cart', []);
        $ids=$req->barcode;
        
        if(isset($cart[$ids]) && isset($cart[$ids]['pid'])==$id)
         {  
            $quent=$cart[$ids]['quantity']+$req->quentity_kg;
            if($sell=='piece')
            {
                
              if($quent > $stock['stock'])
             {
             
              $cart=session()->get('cart');
              return response()->json(['data'=>$cart,'fail'=>'Total'.''.$st.'product left']);

              }else
              { 
               $cart[$ids]['quantity']=$quent;
               $cart[$ids]['sub_total']=$quent*$cart[$ids]['price'];
               $tax_amount=$cart[$ids]['gst']+$vat;
               $cart[$ids]['gst']=number_format($tax_amount, 3, '.', '');
                 
               }
            }else if($sell=='unit')
            {
                
                    $quentity_in_kg=$this->calculatestock($product['pack_quentity'],$req->quentity_kg,$id);
             $quentity_in_kg=$req->quentity_kg + $quentity_in_kg;

            //total stock left
            $order_quentity=$this->totalQuentityLeft($product['pack_quentity'],$stock['stock'],$stock['stock_sold_kg']);


                if($order_quentity < $quentity_in_kg )
                 {
           
                        $cart=session()->get('cart');
                         return response()->json(['data'=>$cart,'fail'=>'Total'.''.$st.'product left']);
                    }else
                    {
                       $cart[$ids]['quantity']=$quent;
                       $cart[$ids]['sub_total']=$cart[$ids]['price']*$cart[$ids]['quantity'];
                       $tax_amount=$cart[$ids]['gst']+$vat;
                       $cart[$ids]['gst']=number_format($tax_amount, 3, '.', '');
                    }
                
            } 
         
         }else
         {

               $cart[$ids] =
                [
                     'id' => $ids,
                     'pid' => $product['product_id'],
                     'purchasing_price' => $stock['purchasing_price'],
                     "name" => $product['product_name'],
                     "quantity" => $req->quentity_kg,
                     "sell_by" => $sell,
                     "unit_id" => $product['unit_id'],
                     "gst" => $vat??0,
                     "price" =>$price ,
                     "sub_total" =>$price2 ,
                     "brand_id" =>$req->brand_id ,
                     "brand_table_id" =>$product['id'] ,
                     "sell_type" => $sell_type,
                     "retailer" => $req->wholesale_one,
                     "pack_quentity" => $product['pack_quentity']

                 ];

         }
       
               
         
          
        session()->put('cart', $cart);
        return response()->json(['data'=>$cart,'success'=>'Successfull']);
        
        }else
        {
             return response()->json(['data'=>$cart]);
        }
          
  }

    public function remove(Request $request)
    {
        if($request->id) 
        {

            $cart = session()->get('cart');

            if(isset($cart[$request->id])) 
            {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
   
          return response()->json(['success'=>'Product removed successfully' ]);
          
        }
    }

    

    

public function updateSessionOrder(Request $request)
{
   $new_q_fit='';
   $new_q_kg='';
   if($request->id && $request->quentity_kg)
   {
     $data = session()->get('cart');
     $quentity= $request->quentity_kg;
     $stock=ProductStock::where('pbrand_id',$request->brand_id)
      ->first();
       $product=Product::where('id',$request->product_id)->select('pack_quentity','gst_tax')
       ->first();

       $vat=$this->gstCalculate($product['gst_tax'],$stock['purchasing_price']);
           
     if($request->sell=='P')
     {
         if($product['pack_quentity'])
         {
          $unit_stock_check=0;
          $cart=session()->get('cart');
            
              foreach($cart as $c)
              {
              
               if($c['pid']==$request->product_id && $c['sell_by']== 'unit')
                {
                 
                 $unit_stock_check += $c['quantity'];

                }
              }
          
               
               $new_quentity=($request->quentity_kg * $product['pack_quentity']) + $unit_stock_check;
              
               $order_quentity=$this->totalQuentityLeft($product['pack_quentity'],$stock['stock'],$stock['stock_sold_kg']);
          }else
          {
             $new_quentity=$request->quentity_kg;
             $order_quentity=$stock['stock'];

          }
        if($new_quentity >$order_quentity)
        {
         
          return response()->json(['data'=>$data,'fail'=>'No more Stock']);
        }else
        {
          $data[$request->id]["quantity"] = $request->quentity_kg;
          $data[$request->id]["gst"] = $vat * $request->quentity_kg;
          $data[$request->id]["sub_total"] = $request->sub_total;
          $data[$request->id]["price"] = $request->price;
          session()->put('cart', $data);
          return response()->json(['success'=>'Product updated  successfully','data'=>$data]);
        }
    
     }else if($request->sell=='U')
     {   


          $pack_stock_check=0;
          
            
              foreach($data as $c)
              {
              
               if($c['pid']==$request->product_id && $c['sell_by']== 'piece')
                {
                 
                 $pack_stock_check += $c['quantity'];

                }
              }
              
               $new_quentity=$request->quentity_kg + ( $product['pack_quentity'] * $pack_stock_check);
                 
               $order_quentity=$order_quentity=$this->totalQuentityLeft($product['pack_quentity'],$stock['stock'],$stock['stock_sold_kg']);
                
               if($order_quentity < $new_quentity)
               {
                  return response()->json(['data'=>$data,'fail'=>'No more Stock']);
                }else
                {
                   $data[$request->id]["quantity"] = $request->quentity_kg;
                  $data[$request->id]["gst"] = ($vat / $product['pack_quentity']) * $request->quentity_kg;
                  $data[$request->id]["sub_total"] = $request->sub_total;
                  $data[$request->id]["price"] = $request->price;
                  session()->put('cart', $data);
                  $cart=session()->get('cart');
                  return response()->json(['success'=>'Product updated  successfully','data'=>$cart]);
                }

           
            }
          
        }
    }



  //get data to print
   // function dataPrint()
   // {
   //    $data=session('cart');
   //    return response()->json($data);
   // }
   function dataCanner(Request $req)
   {

      $data=Product::join('product_brands','products.id','=','product_brands.product_id')->select('product_brands.id','products.sell_by','products.unit_id','product_brands.product_id')->where('product_code',$req->id)->orWhere('unit_barcode',$req->id)->first();
      if($data)
      {
          return response()->json($data);
     
      }else{
      
        return response()->json('No matching Product Found');
     }
   }

    // function getOrders()
    // {
    //    $products = Product::
    //    join('orders','products.id','=','orders.product_id')
    //    ->join('product_stocks','products.id','=','product_stocks.product_id')->paginate(10);
    //    $brands=Brand::all();
    //   //dd($products);
    //      return view('pos.order',compact('products','brands'));
       
    // }

    function getProduct($id)
    {
        $product=Product::where('sub_category_id',$id)->get();
        return response()->json($product);
    }


 function orderPayment(PaymentRequest $req)
 {

   
       // $req->request->add(['branch_id' =>Auth::user()->branch_id]);    
    $data=branch_id($req->all());
     
    DB::transaction(function() use($req,$data)
    {
      $payment=Payment::create($data);
      if($req->customer_id)   
      {
         $account=$req->payable_amount - $req->paying_amount;
         Account::create([
                 
                  'account' =>$account,
                  'customer_id' => $req->customer_id,
                  'account_type' => $req->account_type,
                  'paying_date' => $req->paying_date,
                  'branch_id'=>Auth::user()->branch_id,
          ]);
       }

      if(session('cart'))
              {
                foreach(session('cart') as $details)
                {
            
                  $order= Order::create([

                    'product_id' => $details['pid'],
                    'pack_quentity' => $details['pack_quentity'],
                    'product_name' => $details['name'],
                    'sell' => $details['sell_by'],
                    'quentity' => $details['quantity'],
                    'sub_total' => $details['sub_total'],
                    'unit' => $details['unit_id'],
                    'payment_id' =>$payment['id'],
                    'sell_type' =>$payment['sell_type'],
                    'tax' =>$details['gst'],
                     'branch_id'=>Auth::user()->branch_id,
                    ]);
                }

                foreach(session('cart') as $details)
                {

                  $p= ProductStock::where('pbrand_id',$details['brand_id'])->first();

                  $sold=$p->stock_sold;
                  $left=$p->stock;
                  if($details['sell_by'] == 'piece')
                  {
                    $p->stock_sold=$sold + $details['quantity'];
                    $p->stock=$left - $details['quantity'];
                    $p->save();

                  }else 
                  {
                      $kg=$p->stock_sold_kg;
                      $gram=$p->stock_sold_gram;

                 // if($details['unit_id'] == 1 || $details['unit_id'] == 3 || $details['unit_id'] == 5)
                 //  {
                 //      $p->stock_sold=$sold + $details['quantity'];
                 //      $p->stock=$left - $details['quantity'];
                 //      $p->save();

                 //  }else if($details['unit_id'] == 4)
                 //  {
                     $quentity=$details['quantity'];
                    $soldfit=$p->stock_sold_kg;
                 
                        if($quentity >= $details['pack_quentity'])
                       {
                      
                        // if(empty($gram))
                        //  {
                           if(empty($kg))
                           {
                               $p->stock_sold_kg= $this->quentityKg($quentity,$details['pack_quentity']);
                               $p->stock_sold_gram=null;
                               $p->stock_sold=$sold + $this->kg($quentity,$details['pack_quentity']);
                               $p->stock=$left - $this->kg($quentity,$details['pack_quentity']);
                               $p->save();
                           }else
                           {
                               //if kg for kg is not empty
                               $soldfit2= $soldfit + $quentity;
                               $p->stock_sold_kg=$this->quentityKg($soldfit2,$details['pack_quentity']);
                               $p->stock_sold_gram=null;
                               $p->stock_sold=$sold + $this->kg($soldfit2,$details['pack_quentity']);
                               $p->stock=$left - $this->kg($soldfit2,$details['pack_quentity']);
                               $p->save();
                             
                            }//gk if ended

                          

                      }else{//if q is less than 50
                             
                             if(empty($kg))
                             {
 
                               $p->stock_sold_kg= $quentity;
                               $p->stock_sold_gram=null;
                               $p->stock_sold=$sold + 1;
                               $p->stock=$left - 1;
                               $p->save();

                              }else
                              {//if kg for fit is not empty
                               
                               $soldfit2= $soldfit + $quentity;
                             
                              if($soldfit2 >  $details['pack_quentity'])
                              {
                               
                                $p->stock_sold_kg=$this->quentityKg($soldfit2,$details['pack_quentity']);
                                $p->stock_sold_gram=null;
                                $p->stock_sold=$sold + $this->kg($soldfit2,$details['pack_quentity']);
                                $p->stock=$left - $this->kg($soldfit2,$details['pack_quentity']);
                                $p->save();
                              }else
                              { 
                                $p->stock_sold_kg=$soldfit2 ;
                                $p->save();
                              }

                          }
                      }
                       
                      //kg if endd

                    // }else if($details['unit_id']==2)//length started
                    // {

                      //   $quentity=$details['quantity'] ;
                      //   $soldfit=$p->stock_sold_kg;

                      //   if($quentity >= $details['pack_quentity'])
                      // {

                      //   // if(empty($gram))
                      //   //  {
                      //      if(empty($kg))
                      //      { 
                      //         $p->stock_sold_kg= $this->quentityFit($quentity,$details['pack_quentity']);
                      //         $p->stock_sold_gram=null;
                      //         $p->stock_sold=$sold + $this->fit($quentity,$details['pack_quentity']);
                      //         $p->stock=$left - $this->fit($quentity,$details['pack_quentity']);
                      //         $p->save();
                          
                      //      }else
                      //      {  
                      //         //if kg for fit is not empty
                      //          $soldfit2= $soldfit + $quentity;
                      //          $p->stock_sold_kg=$this->quentityFit($soldfit2,$details['pack_quentity']);
                      //          $p->stock_sold_gram=null;
                      //          $p->stock_sold=$sold + $this->fit($soldfit2,$details['pack_quentity']);
                      //          $p->stock=$left - $this->fit($soldfit2,$details['pack_quentity']);
                      //          $p->save();
                              


                      //      }//gk if ended

                          

                      // }else{//if q is less than 13
                             
                      //        if(empty($kg))
                      //        {
                               
                      //          $p->stock_sold_kg= $quentity;
                      //          $p->stock_sold_gram=null;
                      //          $p->stock_sold=$sold + 1;
                      //          $p->stock=$left - 1;
                      //          $p->save();

                      //         }else
                      //         {
                      //           //if kg for fit is not empty
                      //           $soldfit2= $soldfit + $quentity;
                              
                      //         if($soldfit2 >  $details['pack_quentity'])
                      //         {
                      //           $p->stock_sold_kg=$this->quentityFit($soldfit2,$details['pack_quentity']);
                      //           $p->stock_sold_gram=null;
                      //           $p->stock_sold=$sold + $this->fit($soldfit2,$details['pack_quentity']);
                      //           $p->stock=$left - $this->fit($soldfit2,$details['pack_quentity']);
                      //           $p->save();
                      //         }else
                      //         {
                      //           $p->stock_sold_kg=$soldfit2 ;
                      //           $p->save();
                      //         }

                      //     }
                      // }
                        
                    // }else{
                    //  echo "sorry ....";
                    //}//unit id 3 if end
                    
                    

                  }//sell by if ended

                }//foreach loop ended

              }//session cart ended
             

             session()->forget('cart');
          
            
            });
        
             $payment=Payment::Branch()->latest()->select('id')->first();
             $cart_data=Order::where('payment_id',$payment['id'])
               ->latest()->get();
               $success='Payment Completed';
               $session_data=['success'=>$success,'cart_data'=>$cart_data];
             return response()->json($session_data);
             

    }
}
