<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CopyProductController extends Controller
{
    public function copyProduct(Request $req) 
    {
       

      $products= Product::getProducts();//from Product Model
      $categories= $this->category();
      $sub_categories= $this->scategory();
      $brands= $this->brand();
      $stocks=$stocks=$this->stock->getAllStock();
      
      return view('panel.products.copy_product', compact('products','categories','brands','sub_categories','stocks'));

    }

      public function getProduct(Request $req) {
          
         $products = Product::Branch()->findOrFail($req->id);

        foreach($products as $product)
        {
            $product->brand=ProductBrand::where('product_id',$product['id'])->first();
           
        }
         //from product trait
        $categories= $this->category();
        $sub_categories= $this->scategory();
        $brands= $this->brand();
         $units = Unit::Branch()->get();

          //dd($products);
        return view('panel.products.new_product', compact('products','brands','categories','sub_categories','units'));
     }


     
  //create from existing product in bulk
  // public function copyBulk(Request $request) 
  // {
  
  //   $request->validate([

  //         'stock' => 'required',
  //         'purchasing_price' => 'required'

  //       ]);
   
  //   try {

  //        \DB::beginTransaction();
  //         for ($i=0;  $i < count($request->name); $i++) 
  //          { 

  //             $brand=ProductBrand::where('brand_id',$request->brand_id)->where('product_id',$request->product_id[$i])->first();
              
  //             if(!empty($brand))
  //             { 

  //               $success='brand already exist' ;
  //               return redirect()->back()->with('flash',$success);
  //             }else
  //             {
                
  //               $temp[] = ProductBrand::create([

  //                   'brand_id'=> $request->brand_id,
  //                   'product_id'=> $request->product_id[$i],
                    
  //               ]);
             
  //              foreach($temp as $tmp)
  //               {
  //                 $pb=$tmp['id'];
  //               }
                 
  //              $stock=ProductStock::create([
         
  //               'stock'=> $request->stock[$i],
  //               'pbrand_id' => $pb,
  //               'product_price_piece' =>  $request->product_price_piece[$i] ?? null,
  //               'product_price_piece_wholesale' =>  $request->product_price_piece_wholesale[$i] ?? null,
  //               'product_price_unit '=>  $request->product_price_unit[$i] ?? null,
  //               'product_price_unit_wholesale' =>  $request->product_price_unit_wholesale[$i] ?? null,
  //               'purchasing_price' => $request->purchasing_price[$i],
  //               'active' => 1,
  //              ]);
         
  //             }
                
           

  //           }
  //         \DB::commit();
           
  //           return redirect()->route('products.copy')->with('flash','success');
           
  //       } catch (\Exception $e)
  //       {
  //         return redirect()->back()->with('flash','fail');          
  //       }
  // }

}
