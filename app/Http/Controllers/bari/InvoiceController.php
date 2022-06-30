<?php

namespace App\Http\Controllers\bari;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Brand;
use App\Http\Traits\BariRecieptTraits;
class InvoiceController extends Controller
{
    use BariRecieptTraits;
    public function invoiceOrders()
    {
       $invoices=$this->paymentOrders('invoice');
       $customers=Customer::customers();
       $categories=Category::categories();
       $brands=Brand::brands();
       return view('bari.reciept.invoice',compact('invoices','customers','brands','categories'));
    }


    function ordersDetails($id)
    {
        $payments=Payment::with('orders')->get();
       return view('bari.reciept.order_detail',compact('payments'));
    }


    function destroy($id)
    {
        $this->paymentOrdersDelete($id);
        return redirect()->back()->with('flash','success');
    }
}
