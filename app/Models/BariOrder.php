<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BariOrder extends Model
{
    use HasFactory;
    protected $fillable=
    [

   'description',
   'size',
   'quentity',
   'price',
   'shelf_quentity',
   'component',
   'properties',
   'category_id',
   'payment_id',
   'product_quality',
    
    ];

    public static function findOrers($id)
    {
        return BariOrder::where('payment_id',$id)->get();
    }
}
