<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BariComponent extends Model
{
    use HasFactory;
    protected $fillable=['bri_quentity','bri_product_id','product_id','category_name','sub_category_id'];
}
