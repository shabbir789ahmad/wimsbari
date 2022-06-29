<?php

namespace App\Http\Controllers\bari;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\BariProduct;
use App\Models\BariComponent;
use App\Http\Traits\ImageTrait;
use DB;
class BariController extends Controller
{

    use ImageTrait;

    function index()
    {
        $products=BariProduct::products($quotation=0);
        $categories = Category::categories();
        return view('bari.product.index',compact('products','categories'));
    }


    public function create()
    {
        $brands = Brand::brands();
        $categories = Category::categories();
        return view('bari.product.create',compact('brands','categories'));
    }

    function product($id)
    {
        $categories=SubCategory::Branch()->where('category_id',$id)->get();
        
        foreach($categories as $category)
        {

        $product=Product::Branch()->get();
        }
  
        return response()->json(['product'=>$product,'categories'=>$categories]);
    }

    function store(Request $request)
    {
      
      
      \DB::beginTransaction();
         $product=$this->createProduct($request,$id='');
      
          $this->createComponent($product,$request);
       DB::commit();
      if($request->quotation)
      {
       return redirect()->route('bari.quotation.index');
      }else{
        return redirect()->route('bari.index');
      }
       

    }

    function createProduct($request,$id)
    {
      return  BariProduct::updateOrCreate(
         [
            'id'=>$id,
         ],
        [
         'bri_product_name'=>$request->bri_product_name,
         'size'=>$request->size,
         'rate'=>$request->rate,
         'quotation'=>$request->quotation??0,
         'bri_brand_id'=>$request->bri_brand_id,
         'bri_category_id'=>$request->bri_category_id,
         'bri_image'=>$this->image(),
      ]);
    }

    function createComponent($product,$request)
    { 
        
        for($i=0; $i<count($request->bri_product_id); $i++ )
      {
         BariComponent::create(
            
            [
         'product_id'=>$request->bri_product_id[$i],
         'bri_quentity'=>$request->bri_quentity[$i],
         'category_name'=>$request->category_name[$i],
         'bri_product_id'=>$product['id'],
         'sub_category_id'=>$request->sub_category_id[$i],
        ]);
      }
    }



    public function edit($id)
    {
        $product = BariProduct::with('components')->where('id',$id)->first();
       
        $productComponents=Product::where('category_id',$product['bri_category_id'])->get();

        $brands = Brand::brands();
        $categories = Category::categories();
        return view('bari.product.edit',compact('product','categories','productComponents','brands'));
    }


    function Update(Request $request,$id)
    {
      
      
      \DB::beginTransaction();
         $product=$this->createProduct($request,$id);
       
      for($i=0; $i<count($request->bri_product_id); $i++ )
        {
         BariComponent::updateOrCreate(
            [
              'id'=>$request->ids[$i],
            ],
            [
         'product_id'=>$request->bri_product_id[$i],
         'bri_quentity'=>$request->bri_quentity[$i],
         'category_name'=>$request->category_name[$i],
         'bri_product_id'=>$product['id'],
        ]);
       }
       DB::commit();

     if($request->quotation)
      {
       return redirect()->route('bari.quotation.index');
      }else{
        return redirect()->route('bari.index');
      }
      

    }

    function destroy($id)
    {
        BariProduct::destroy($id);
        return redirect()->back();
       
    }
}
