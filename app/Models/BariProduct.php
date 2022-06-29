<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BariProduct extends Model
{
    use HasFactory;
    protected $fillable=
    [
        'bri_product_name',
        'size',
        'rate',
        'bri_image',
        'bri_category_id',
        'bri_brand_id',
        'quotation',
    ];

    function components()
    {
        return $this->hasMany(BariComponent::class,'bri_product_id');
    }

    function getbriProductNameAttribute($value)
    {
        return ucfirst($value);
    }
    
    public static function products($quotation)
    {
        $product= BariProduct::with('components')
        ->join('categories','categories.id','bari_products.bri_category_id')
        ->join('brands','brands.id','bari_products.bri_brand_id')
        ->select('categories.category_name','bari_products.rate','bari_products.size','bari_products.bri_product_name','bari_products.id','bari_products.bri_image','brands.brand_name',)->where('quotation',$quotation);
       
        return $product=$product->get();
    }
}
