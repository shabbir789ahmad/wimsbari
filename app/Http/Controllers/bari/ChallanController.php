<?php

namespace App\Http\Controllers\bari;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\BariRecieptTraits;
class ChallanController extends Controller
{
    use BariRecieptTraits;
    public function challanOrders()
    {
       $challans=$this->paymentOrders('challan');
       return view('bari.reciept.challan',compact('challans'));
    }
}
