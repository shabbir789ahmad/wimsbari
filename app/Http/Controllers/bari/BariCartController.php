<?php

namespace App\Http\Controllers\bari;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BariProduct;
use App\Models\Product;
use Session;
use App\Helpers\BariStockHelper;
class BariCartController extends Controller
{

    protected $productHelper;
    function __construct(BariStockHelper $products)
    {
       $this->productHelper=$products;
    }

   public function cart(Request $request)
    {
        $id=$request->id;
        $bcart=$this->carts();
        $bccart=$this->bccart();
      $data= $this->productHelper->checkStock($id,$request->quentity,$bcart,$bccart);
      
      if($data=='fail')
        {
            return response()->json(['bcart'=>$this->carts(),'bccart'=>$this->bccart(),'success'=>'You Dont Have More Stock']);
        }
       
       $products= BariProduct::findorfail($id);
      
        $bcart = session()->get('bcart', []);
       
        if(isset($bcart[$id]))
         {
           
           $data= $this->productHelper->checkStock($id,$bcart[$id]['quantity']+1,$bcart,$bccart);
          
          if($data=='fail')
        {
            return response()->json(['bcart'=>$this->carts(),'bccart'=>$this->bccart(),'success'=>'You Dont Have More Stock']);
        }
        
           $bcart[$id]['quantity']=$bcart[$id]['quantity']+1;

           $bcart[$id]['sub_total']=$bcart[$id]['quantity']*$bcart[$id]['price'];
           
        }else
         {
            
            $bcart[$id] = [
                'id' => $id,
                     "name" => $products['bri_product_name'],
                     "size" => $products['size'],
                     "quantity" => $request->quentity,
                     "price" =>$products['rate'] ,
                     "sub_total" =>$products['rate'] *$request->quentity ,

            ];
            
        }
        
        session()->put('bcart', $bcart);
        return response()->json(['bcart'=>$bcart,'bccart'=>$this->bccart(),'success'=>'Successfull']);
    }


  


    function update(Request $request)
    {

        if($request->id) 
        {
          $bcart =$this->carts();

          if(isset($bcart[$request->id])) 
            {
                $bcart[$request->id]['quantity']=$request->quentity;
                $bcart[$request->id]['sub_total']=$bcart[$request->id]['price']*$request->quentity;
                session()->put('bcart', $bcart);
            }
            $bcart = $this->carts();
      
            return response()->json(['bcart'=>$bcart,'bccart'=>$this->bccart(),'success'=>'Successfull']);

        }
    }

    function delete(Request $request)
    {

      if($request->id) 
        {

            $bcart = $this->carts();

            if(isset($bcart[$request->id])) 
            {
                unset($bcart[$request->id]);
                session()->put('bcart', $bcart);
            }
            $bcart = $this->carts();
          return response()->json(['bcart'=>$bcart,'bccart'=>$this->bccart(),'success'=>'Successfull']);
          
        }
    }

    function carts()
    {
        return  session()->get('bcart');;
    }
    function bccart()
    {
        return  session()->get('bccart');;
    }
}
