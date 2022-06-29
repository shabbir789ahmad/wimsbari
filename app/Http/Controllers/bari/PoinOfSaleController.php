<?php

namespace App\Http\Controllers\bari;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BariProduct;
use App\Models\BariComponent;
use App\Models\Product;
class PoinOfSaleController extends Controller
{
     public function index() {
        $products= BariProduct::products($q=0);
        $components=Product::getProducts();
     
      return view('bari.pos.pos',compact('products','components'));

    }


    function compontents(Request $request)
    {
      
       $compontents=BariComponent::where('bri_product_id',$request->id)->get('product_id');
       
       foreach($compontents as $com)
       {

         $products[]=Product::where('id',$com->product_id)->select('product_name','product_image','id')->get();
       }
      // dd($products);
       return response()->json($products);

    }

   
}
