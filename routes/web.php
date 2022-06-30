<?php
use  App\Models\ProductBrand;
use  App\Models\Brand;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Panel\BrandController;
use App\Http\Controllers\Panel\UnitController;
use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\SubCategoryController;
use App\Http\Controllers\Panel\SupplierController;
use App\Http\Controllers\Panel\ProductController;
use App\Http\Controllers\Panel\CopyProductController;
use App\Http\Controllers\Panel\WhereHouseController;
use App\Http\Controllers\Panel\BranchController;
use App\Http\Controllers\Panel\BarcodeController;

use App\Http\Controllers\Pos\MainController;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\PayableController;
use App\Http\Controllers\ReturnProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpenseTypeController;



 

Route::get('/', [AuthController::class, 'login'])->name('login');
//password reset linkd
Route::get('/forgot/password', [PasswordController::class, 'forgotPasswordEmail'])->name('forgot.password');
Route::post('password/reset/email', [PasswordController::class, 'sendForgotPasswordEmail'])->name('password.reset.email');
Route::get('reset/{token}password', [PasswordController::class, 'resetView'])->name('reset.password');
Route::post('password/reset', [PasswordController::class, 'resetPassword'])->name('password.reset');


// register users
Route::get('/admin/register',[AuthController::class,'register'])->name('regirter');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/admin/register', [AuthController::class, 'registerAdmin'])->name('register');

Route::middleware(['auth:admin', 'meta'])->group(function() {
 //logoutr user 
  Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
  //redirect user without permission
  Route::view('no-permission','permission');
  
  Route::middleware('rolescheck')->group(function(){

   Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');
 });

 //route only admin can see and oprate
 Route::middleware('adminonly')->group(function()
 {

  //brand resource route
     Route::resource('brands', BrandController::class);
 //unit route
     Route::resource('units', UnitController::class);
 //category route
    Route::resource('categories', CategoryController::class);
 //sub category route
    Route::resource('sub-categories', SubCategoryController::class);
 //supplier route
    Route::resource('suppliers', SupplierController::class);
 //change branch name
    Route::resource('branch', BranchController::class);  
 //create report
    Route::resource('report', ReportController::class);
 //create crediential
    Route::resource('wherehouse', WhereHouseController::class);
 // add admin create user
    Route::resource('user', UserController::class);
   
 //generate barcode
      Route::resource('barcode', BarcodeController::class);
      Route::get('product/{id}/barcode',[BarcodeController::class,'productBarcode'])->name('product.barcode');
       Route::get('sub-categories/{id}/product',[BarcodeController::class,'product'])->name('sub-categories.product');

   // add or show customer route
       Route::resource('customer', CustomerController::class);
       Route::get('ajax/customer', [CustomerController::class, 'ajaxCustomer']);
   // return product by customer route

    Route::resource('return',ReturnProductController::class);
    Route::get('invoice/data', [ReturnProductController::class, 'create'])->name('invoice.data');
   




    //product route
     Route::resource('products', ProductController::class);
    //update product single and in  bulk route
     Route::post('/products/bulk/update', [ProductController::class, 'updateProduct'])->name('products.bulk.update');
    Route::get('/bulk', [ProductController::class, 'UpdateBluk'])->name('update.bulk');
    Route::get('/get-products2', [ProductController::class, 'getProduct2'])->name('products.get2');
   
   
   //create new from existing product route
     Route::get('/products/copy', [CopyProductController::class, 'copyProduct'])->name('products.copy');
     Route::get('/get-products', [CopyProductController::class, 'getProduct'])->name('products.get');
     Route::post('/products-bulk-new', [CopyProductController::class, 'copyBulk'])->name('products.copyBulk');
    
    //stock management  route

     Route::resource('stock',StockController::class);
    Route::get('/active/stock', [StockController::class, 'activeStock']);




      
   //get categories to show on all pages
     Route::get('categories/{id}/sub-categories', function() {

        $data = \DB::table('sub_categories')
            ->select('sub_categories.*')
            ->join('categories', 'categories.id', 'sub_categories.category_id')
            ->where('categories.id', request('id'))
            ->get();
        
        return response()->json($data);

    });
 });


   





   

    
   
//point of Sale
   Route::get('/pos/products/get/{id}', [MainController::class, 'product'])->name('pos.index');
   Route::get('/cancel-order', function() {session()->forget('cart');});
   Route::get('pos/acount-data',[CustomerController::class,'accountData']);
   Route::get('pos/sale-data',[SaleController::class,'SaleData']);


   // order routes
    Route::get('product-get/{id}',[OrderController::class,'getProduct'])->name('product-get/{id}');
   Route::delete('delete/{id}', [OrderController::class, 'remove']);

  //expensses route and payment route
   Route::resource('expense',ExpenseTypeController::class);
   Route::resource('expence',ExpenseController::class);
   
     

     //payment payable route and payment route
     
      Route::get('payable/index',[PayableController::class,'index'])->name('payable.index');
     Route::get('payable/supplier',[PayableController::class,'supplier'])->name('payable.supplier');
      Route::Post('/payable/create',[PayableController::class,'create'])->name('payable.create');
      Route::post('pay/now/{id}', [PayableController::class, 'payNow'])->name('pay.now');
     Route::get('/supplier',[PayableController::class,'allSupplier'])->name('supplier');

//ghbfgh
      Route::post('payment/{id}/get',[PaymentController::class,'paymentRecieve'])->name('payment.edit');
      //installment routes
      Route::get('payment/recive',[InstallmentController::class,'index'])->name('payment/recive');
      Route::get('/get/payment/installment',[InstallmentController::class,'accountInstallment']);
      Route::post('make/Installment',[InstallmentController::class,'makeInstallment'])->name('make.Installment');
      Route::post('/recieve/payment/from/customer',[PaymentController::class,'paymentRecieve']);
     Route::get('account/{id}/all_instalment',[InstallmentController::class,'accountInstallment'])->name('account.installment');
     Route::get('/recieve/installment',[InstallmentController::class,'recieveInstallment']);
     Route::get('/new/installment',[InstallmentController::class,'newInstallmentindex']);



  
  
    
    
//brand route for pos filter brand

    Route::get('pos/brand/{id}', function() {
     $id=request('id');
        $query = Brand::Branch();

        if($id != 0)
        {
         $query=$query->join('product_brands','brands.id','=','product_brands.brand_id')->where('product_brands.product_id',$id);
        }
        
        $data=$query->get();
        return response()->json($data);

    });


//pos with session route
    Route::post('order/session', [OrderController::class, 'order']);
    Route::post('/order/order/printer', [OrderController::class, 'orderPayment']);
    Route::get('/order/scanner', [OrderController::class, 'dataCanner']);
    Route::delete('delete/', [OrderController::class, 'remove']);
    Route::post('pos/update/orders/ajax', [OrderController::class, 'updateSessionOrder']);

//pos orders and payment route
   Route::post('pos/orders', [OrderController::class, 'order']); 
   Route::post('pos/payment', [OrderController::class, 'orderPayment'])->name('order.payment'); 
   
 

   Route::get('/pos/get/orders/ajax', function() {

        $data = \DB::table('orders')->latest()->first();
        
        return response()->json($data);

    });

});
