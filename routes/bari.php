<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\SubCategory;
use App\Http\Controllers\bari\BariController;
use App\Http\Controllers\bari\PoinOfSaleController;
use App\Http\Controllers\bari\BariCartController;
use App\Http\Controllers\bari\BariOrderController;
use App\Http\Controllers\bari\BariCartComponentController;
use App\Http\Controllers\bari\DailySaleController;
use App\Http\Controllers\bari\InvoiceController;
use App\Http\Controllers\bari\ChallanController;
use App\Http\Controllers\bari\QuotationController;




Route::middleware(['auth:admin'])->group(function() {
   
   Route::get('bari/index',[BariController::class,'index'])->name('bari.index');
	Route::get('bari/create',[BariController::class,'create'])->name('bari.create');
    Route::post('bari/product/store',[BariController::class,'store'])->name('bari.product.store'); 
    Route::get('bari/{id}/edit',[BariController::class,'edit'])->name('bari.edit');
    Route::put('bari/product/{id}/update',[BariController::class,'update'])->name('bari.product.update');
    Route::delete('bari/product/{id}delete',[BariController::class,'destroy'])->name('bari.product.delete');



    //cart orders crud operation
    Route::post('/bari/order/session',[BariCartController::class,'cart'])->name('bari.order.session');

    Route::post('/bari/update/orders',[BariCartController::class,'update'])->name('bari.update.orders');
    Route::delete('/bari/delete',[BariCartController::class,'delete'])->name('bari.delete');


    //componrt add
    Route::post('/bari/order/component/session',[BariCartComponentController::class,'cartComponent']);
    Route::delete('/bari/delete/component',[BariCartComponentController::class,'delete']);
   Route::post('/bari/update/orders/component',[BariCartComponentController::class,'update']);
  //
    Route::post('/order/bari/printer',[BariOrderController::class,'order']);
    

//get compoetn from product table  to make deal
  Route::get('categories/{id}/sub-categories/product',[BariController::class,'product']);


//pos route
 Route::get('bari/point-of-sale',[PoinOfSaleController::class,'index'])->name('bari.pos');

 Route::get('/bari/components',[PoinOfSaleController::class,'compontents']);





 //get daily sale here
  Route::get('/bari/daily/sale',[DailySaleController::class,'dailySale']);

  //route for different reciept data ,delivery challan, invoice 
  // and quoatation
  Route::get('/bari/invoice',[InvoiceController::class,'invoiceOrders'])->name('bari.invoice');


  Route::delete('/bari/delete/orders/{id}',[InvoiceController::class,'destroy'])->name('bari.delete.order');
  Route::get('/bari/order/{id}/detail',[InvoiceController::class,'ordersDetails'])->name('bari.order.detai');


  Route::get('/bari/quotation',[QuotationController::class,'quotationOrders'])->name('bari.quotation');


  Route::get('/bari/challan',[ChallanController::class,'challanOrders'])->name('bari.challan');

 
});