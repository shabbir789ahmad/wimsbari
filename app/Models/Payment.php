<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\Order;
class Payment extends Model
{
    use HasFactory;
    protected $fillable=[

      'biller_name',
      'paying_by',
      'paying_amount',
      'payable_amount',
      'reciept_type',
      'cheque_no',
      'cheque_image',
      'discount',
      'tax',
      'sr_number',
      'customer_id',
      'customer_name',
      'branch_id',
   
      
    ];

 
    public static function scopeBranch($query)
    {
       return $query->where('payments.branch_id',Auth::user()->branch_id);
    }
   //accessor
   public function getBillerNameAttribute($value)
    {
        return ucfirst($value);
    }

    function orders()
    {
       return $this->hasMany(BariOrder::class); 
    }
}
