<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductBrand;
use App\Models\ProductStock;
use App\Models\SubCategory;
use Auth;
class StockController extends Controller
{
    function index(Request $request)
    {
   
   
        $products=Product::Branch()->findOrFail($request->id);
        $categories=Category::Branch()->where('id',$products['category_id'])->first('category_name');
        $sub_categories=SubCategory::Branch()->where('id',$products['sub_category_id'])->first('sub_category_name');
        
        
        $brands=ProductBrand::where('product_id',$request->id)->first();
        $pbrand=Brand::Branch()->where('id',$brands->brand_id)->first('brand_name');
           $stock=ProductStock::Branch()->where('pbrand_id',$brands['id'])->sum('stock');

           $brand_stock=ProductStock::where('pbrand_id',$brands->id)->get();
     
      
        return view('panel.stock.stock',compact('products','categories','sub_categories','pbrand','brands','stock','brand_stock'));
    }

    function store(Request $request)
    {
        
        $request->validate([
         
           'stock_id' => 'required',
           'stock' => 'required',

        ]);

        $data=[
         
          'pbrand_id' => $request->stock_id,
          'stock' => $request->stock,
          'purchasing_price' => $request->purchasing_price,
          'product_price_piece' => $request->product_price_piece,
          'product_price_piece_wholesale' => $request->product_price_piece_wholesale,
          'product_price_unit' => $request->product_price_unit,
          'product_price_unit_wholesale' => $request->product_price_unit_wholesale,
          'branch_id' =>Auth::user()->branch_id,
          'active'=>'0'
        ];
   

        try {

            ProductStock::create($data);

            \App\Helpers\Logger::logActivity(\Route::currentRouteName());

            return redirect()->back()->with('flash','success');
            
        } catch (\Exception $e) {

           return redirect()->back()->with('fail','success');
            
        }
    
        
    }


    function update(Request $request,$id)
    {
        $data=[
           'stock' =>$request->stock,
           'product_price_piece'=>$request->product_price_piece,
           'product_price_unit'=>$request->product_price_unit,
           'product_price_piece_wholesale'=>$request->product_price_piece_wholesale,
           'product_price_unit_wholesale'=>$request->product_price_unit_wholesale,
           'branch_id'=>Auth::user()->branch_id,
        ];
        $stock=ProductStock::where('id',$id)->update($data);
        
        return back()->with('flash','success');
    }



    function destroy($id)
    {
        $stock=ProductStock::destroy($id);
        
        return back()->with('flash','success');
    }

    function activeStock(Request $req)
    {
       $pro=ProductStock::where('id',$req->id)->update(['active'=>$req->active]);
       return response()->json('updated');
    }
}