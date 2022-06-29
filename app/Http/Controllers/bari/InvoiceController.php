<?php

namespace App\Http\Controllers\bari;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Traits\BariRecieptTraits;
class InvoiceController extends Controller
{
    use BariRecieptTraits;
    public function invoiceOrders()
    {
       $invoices=$this->paymentOrders('invoice');
       return view('bari.reciept.invoice',compact('invoices'));
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
