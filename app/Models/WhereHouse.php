<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
class WhereHouse extends Model
{
    use HasFactory;
    protected $fillable=['where_house_name','where_house_location','branch_id'];

    public function scopeBranch( $query) {

       return $query->where('branch_id',Auth::user()->branch_id);
        
    }


    public static function wherehouses()
    {
      return WhereHouse::Branch()->get();
    }
}
