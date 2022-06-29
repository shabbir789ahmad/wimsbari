<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class Expence extends Model
{
    use HasFactory;
    protected $fillable=[ 'expense_id' , 'expense' ,'name','branch_id'];

 // accessor
   public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function scopeBranch( $query) {

       return $query->where('branch_id',Auth::user()->branch_id);
        
    }

   

    
}
