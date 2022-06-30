<?php

namespace App\Http\Controllers\bari;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Brand;
use App\Http\Traits\BariRecieptTraits;
class QuotationController extends Controller
{
    use BariRecieptTraits;
    public function quotationOrders()
    {
       $quotations=$this->paymentOrders('quotation');
       $customers=Customer::customers();
       $categories=Category::categories();
       $brands=Brand::brands();
       return view('bari.reciept.quotation',compact('quotations','customers','brands','categories'));
    }
    
   

}
