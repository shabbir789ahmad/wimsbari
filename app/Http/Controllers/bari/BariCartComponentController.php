<?php

namespace App\Http\Controllers\bari;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductStock;
use App\Helpers\BariStockHelper;
class BariCartComponentController extends Controller
{
    protected $productHelper;
    function __construct(BariStockHelper $products)
    {
       $this->productHelper=$products;
    }


     public function cartComponent(Request $request)
    {
     
      
        $id=$request->id;
        $products= $this->productHelper->product($id);
        $stock=$this->productHelper->stock($products['id']);
        
      if($stock == null )
      {

         return response()->json(['bccart'=>$this->carts(),'bcart'=>$this->bcart(),'success'=>'You Dont HAve More Stock']);
      }else{


        $bccart = session()->get('bccart', []);
       
        if(isset($bccart[$id]))
         {
            if($stock['stock'] > $bccart[$id]['quantity']+1)
            {
             $bccart[$id]['quantity']=$bccart[$id]['quantity']+1;

             $bccart[$id]['sub_total']=$bccart[$id]['quantity']*$bccart[$id]['price'];
           }else
           {
              return response()->json(['bccart'=>$this->carts(),'bcart'=>$this->bcart(),'success'=>'You Dont Have More Stock']);
           }

        }else
         {
            
            $bccart[$id] = [
                'id' => $id,
                     "name" => $products['product_name'],
                     "price" => $stock['product_price_piece'],
                     "sub_total" => $stock['product_price_piece'],
                     "quantity" => $request->quentity,
                     

            ];
            
        }
        
        session()->put('bccart', $bccart);

        }
        return response()->json(['bccart'=>$bccart,'bcart'=>$this->bcart(),'success'=>'Successfull']);
    }



    function update(Request $request)
    {


        if($request->id) 
        {
            //use this to get product stock
            $products= $this->productHelper->product($request->id);
            $stock=$this->productHelper->stock($products['id']);

            if($stock==null || $stock['stock'] < $request->quentity)
            {
              $bccart = $this->carts();
      
               return response()->json(['bccart'=>$bccart,'bcart'=>$this->bcart(),'success'=>'No More Stock Left']);
            }else
            {

               $bccart =$this->carts();

              if(isset($bccart[$request->id])) 
               {
                  $bccart[$request->id]['quantity']=$request->quentity;
                  $bccart[$request->id]['sub_total']=$bccart[$request->id]['price']*$request->quentity;
                  session()->put('bccart', $bccart);
                }
            }   
               $bccart = $this->carts();
      
            return response()->json(['bccart'=>$bccart,'bcart'=>$this->bcart(),'success'=>'Successfull']);

        }
    }




    function delete(Request $request)
    {
 
      if($request->id) 
        {

            $bccart = $this->carts();

            if(isset($bccart[$request->id])) 
            {
                unset($bccart[$request->id]);
                session()->put('bccart', $bccart);
            }
            $bccart = session()->get('bccart');
          return response()->json(['data'=>$bccart,'success'=>'Product removed successfully' ]);
          
        }
    }

    function carts()
    {
        return  session()->get('bccart');;
    }
    function bcart()
    {
        return  session()->get('bcart');;
    }
}
