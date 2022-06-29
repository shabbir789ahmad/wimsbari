<?php 
namespace App\Helpers;
/**
 * this class hep to get product table 
 * record for recorder maintanence
 */
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\BariComponent;
class BariStockHelper 
{

   function product($id)
    {
       return Product::
          join('product_brands','products.id','=','product_brands.product_id')
          ->select('products.product_name','product_brands.product_id','products.sell_by','product_brands.id')
          ->where('products.id',$id)
          ->Branch()
          ->first();
        
    }

    function stock($brand_id)
    {

        return ProductStock::
               where('pbrand_id',$brand_id)
             ->where('active','1')
             ->where('stock','>',0)
             ->select('stock','product_price_piece','product_price_piece_wholesale')
             ->Branch()
             ->first();
    }


    function components($bari_product_id)
    {

        return BariComponent::
              where('bri_product_id',$bari_product_id)
            ->select('product_id','bri_quentity')
           ->get();
    }


    function checkStock($id,$quentity,$bcart,$bccart)
    {
        // get componetn to check stock
    	$compontents= $this->components($id);
      
        foreach($compontents as $com)
        {
         $products= Product::
            join('product_brands','products.id','=','product_brands.product_id')
            ->join('product_stocks','product_brands.id','=','product_stocks.pbrand_id')
            ->select('products.product_name','product_brands.product_id','products.sell_by','product_brands.id','product_stocks.stock')
            ->where('product_stocks.active','1')
            ->where('stock','>',0)
            ->where('products.id',$com['product_id'])
            ->Branch()
            ->first();
            if( $products==null)
            {
              return $data='fail';
            }else{
           
             if(($com['bri_quentity']* $quentity) > $products['stock'] && $products['id']==$com['product_id'])
           
            {
                return $data='fail';
               
            }
         }
        }
    }

}