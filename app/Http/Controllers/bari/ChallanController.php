<?php

namespace App\Http\Controllers\bari;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Brand;
use App\Http\Traits\BariRecieptTraits;
class ChallanController extends Controller
{
    use BariRecieptTraits;
    public function challanOrders()
    {
       $challans=$this->paymentOrders('challan');
       $customers=Customer::customers();
       $categories=Category::categories();
       $brands=Brand::brands();
       return view('bari.reciept.challan',compact('challans','customers','brands','categories'));
    }
}
