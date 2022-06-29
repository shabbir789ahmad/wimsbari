<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
class Account extends Model
{
    use HasFactory;
     use SoftDeletes;
    protected $fillable=['account','paying_date','account_type','customer_id','admin_id'];

     public function scopeBranch( $query) {

       return $query->where('branch_id',Auth::user()->branch_id);
        
    }
}
