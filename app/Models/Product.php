<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use DB;
use App\Casts\CapitalizeCast;
use Auth;
class Product extends Model {

    use HasFactory;
   protected $casts=[
    'product_name' => CapitalizeCast::class, 
     ];

    public $fillable = [

        
        'category_id', 
        'sub_category_id', 
        'product_name', 
        'tax', 
        'sell_by',
        'unit_id',
        'product_image',
        'branch_id',
        'where_house_id',
        'admin_id',
        'product_qualities',
       
        'pack_quentity',

    ];


    
    public function scopeBranch( $query) {

       return $query->where('products.branch_id',Auth::user()->branch_id);
        
    }
  
  // product id for bari stock managment
   public static function productId($product_id)
    {
     return Product::
         join('product_brands','products.id','=','product_brands.product_id')
         ->select('product_brands.id')
         ->where('products.id',$product_id)
         ->first();
    }


   // this function get all product
    public static function getProducts() {
        
        $req=app('request');
        $sub_cat_id='';
        $brand_search='';
        if($req->get('sub_category') != null)
        {
            $sub_cat_id=$req->get('sub_category');
        }
        if($req->get('brand_se') != null)
        {
            $brand_search=$req->get('brand_se');
        }
        $ex=explode(",",$sub_cat_id);
       
       
        $query = DB::table('products')
            ->select('categories.category_name', 'sub_categories.sub_category_name', 'products.product_name','products.product_image','products.sub_category_id','products.id')
            
            ->join('categories', 'categories.id', 'products.category_id')
            ->join('sub_categories', 'sub_categories.id', 'products.sub_category_id');
            
         
          if($ex && $brand_search)
          {
              
            $query=$query->join('product_brands','products.id','=','product_brands.product_id')->whereIn('sub_category_id',$ex)->where('brand_id',$brand_search); 
              
           }
          
         
         $data=$query->where('products.branch_id',Auth::user()->branch_id)->get();
          foreach($data as $product)
        {
            $product->brand=ProductBrand::where('product_id',$product->id)->get();
        }
        return $data;

    }

}
