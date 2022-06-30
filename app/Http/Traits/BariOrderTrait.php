<?php 
namespace App\Http\Traits;

use App\Models\Payment;
use App\Models\BariOrder;

trait BariOrderTrait
{
  // this function generate serial number for 
  //different type of reciept
  //it takes two argument $sr_number
   //which is the object of last payment added
   //and $type  whch define the type of reciept
 private function srNumber($sr_number,$type)
    {
        if(!$sr_number)
           {
             $sr_number=$type.'1';
           }else{
            $sr_number=substr($sr_number['sr_number'],2);
            $sr_number=$type.++$sr_number;
           }
           return $sr_number;
    }

  // this function return lates payment record added
    // for the specific reciept type
    function payments()
    {
        $request=app('request');
        return Payment::Branch()
                    ->latest()
                    ->select('id','paying_amount','discount','tax','sr_number')
                    ->where('reciept_type',$request->reciept_type)
                    ->first();;
    }

  // this function return latest product added to order table
    // product are two type productcomponent and product
    function productOrder($payment)
    {
        $cart_data=BariOrder::
                   where('payment_id',$payment['id'])
                  ->latest()->whereNull('component')->get();
        $cart_data2=BariOrder::
                   where('payment_id',$payment['id'])
                  ->latest()->whereNotNull('component')->get();
        
        return ['cart_data'=>$cart_data,'cart_data2'=>$cart_data2];
    }

}

?>