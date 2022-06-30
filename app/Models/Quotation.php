<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
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
   'payment_id',
    
    ];
}
