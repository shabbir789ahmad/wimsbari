<?php 
namespace App\Http\Traits;

use App\Models\Payment;
use App\Models\BariOrder;
use App\Models\Product;
use App\Models\Customer;
use App\Models\ProductStock;

trait BariRecieptTraits{

	/**
    *this  function  get data by 
    * reciept type for different reciept 
    **/
   function paymentOrders($reciept)
   {
    $request=app('request');
       $query=Customer::
       join('payments','customers.id','=','payments.customer_id')
       ->join('bari_orders','payments.id','=','bari_orders.payment_id')
        ->select('customers.customer_name','payments.*','bari_orders.category_id')
          ->where('reciept_type',$reciept);
          
          if($request->by_customer !== null)
          {
           $query=$query->where('customer_id',$request->by_customer);
          }
          if($request->by_category_id !== null)
          {
           $query=$query->where('bari_orders.category_id',$request->by_category_id);
          }

         return  $orders=$query->paginate(50);
           
   }
   

   /**
    *this  function  get data by 
    * reciept type for different reciept 
    **/
   function paymentOrdersDetail($reciept,$id)
   {
        return Payment::with('bariOrders')
               ->where('reciept_type',$reciept)
               ->where('id',$id)
               ->get();
   }

   /**
    *this  function  get data by 
    * reciept type for different reciept 
    **/
   function paymentOrdersDelete($id)
   {
        $payment=Payment::findOrFail($id);
  
        //from bariorder Model
        $orders=BariOrder::findOrers($payment->id);

        foreach($orders as $order)
        {
      
        	// from product model to get product ids
          foreach(json_decode($order->properties,true) as $property)
          { 
              $product=Product::productId($property['product_id']);
               // get stock data with this function from ProductStock Model
                $stock=ProductStock::stockManage($product['id']);
               
               //manage Stock here
               //loop properties json column
    
               $stock->stock=$stock->stock+($property['q']*$order['shelf_quentity']);
               $stock->stock_sold=$stock->stock_sold - ($property['q']*$order['shelf_quentity']);
              $stock->save();
          }
        	}
      
       $payment->delete();

   }
}