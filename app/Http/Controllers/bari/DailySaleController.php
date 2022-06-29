<?php

namespace App\Http\Controllers\bari;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Account;
use App\Models\Expence;
use Carbon\Carbon;

class DailySaleController extends Controller
{
    function dailySale()
    {
        $sale=Payment::Branch()->whereDate('created_at', Carbon::today())->sum('paying_amount');
        $recieve=Account::Branch()->whereDate('deleted_at', Carbon::today())->onlyTrashed()->sum('account');
        $exp=Expence::whereDate('created_at', Carbon::today())->sum('expense');
          $sl=$sale+$recieve;
        $netsale= $sl - $exp;
             
         
    
        return response()->json(['sale'=>$sale,'recieve'=>$recieve,'netsale'=>$netsale,'exp'=>$exp]);
    }
}
