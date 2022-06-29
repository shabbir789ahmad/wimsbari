<?php

namespace App\Http\Controllers\bari;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\BariProduct;
use App\Http\Traits\BariRecieptTraits;
class QuotationController extends Controller
{
    use BariRecieptTraits;
    public function quotationOrders()
    {
       $quotations=$this->paymentOrders('quotation');
       return view('bari.reciept.quotation',compact('quotations'));
    }
    
   

}
