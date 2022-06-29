<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class Expense extends Model
{
    use HasFactory;
    protected $fillable=['expence_type','branch_id'];

     public function scopeBranch( $query) {

       return $query->where('branch_id',Auth::user()->branch_id);
        
    }
    // accessor
    public function getExpenceTypeAttribute($value)
    {
        return ucfirst($value);
    }
    function expenses()
    {
      return $this->hasMany(Expence::class,);
    }

     public static function expenseType()
    {
      return Expense::Branch()->orderBy('id','DESC')->get();
    }
}
