<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expence;
use App\Models\Expense;
use Carbon\Carbon;
use DB;
use Auth;
use App\Helpers\BranchHalper;
class ExpenseController extends Controller
{

    function index()
    {
        $expense_type=Expense::expenseType();
        $expenses=Expence::Branch()->orderBy('id','DESC')->get();
       
        return view('expense.expenses.index',compact('expenses','expense_type'));
    }

    function store(Request $request)
    {
        
        Expence::create([

            'expense_id' => $request->e_type,
            'expense' => $request->expense_amount,
            'name' => $request->expense_user,
            'branch_id'=>Auth::user()->branch_id,
        ]);
        $data='sdsd';
        return response()->json($data);
    }
 

   function edit($id)
    {
        $expense=Expence::findorfail($id);
        $expense_type=Expense::expenseType();
        return view('expense.expenses.edit',compact('expense','expense_type'));
    }
   

   function update(Request $req,$id)
    {

        Expence::where('id',$id)->update([

            'expense_id' => $req->e_type,
            'expense' => $req->expense_amount,
            'name' => $req->expense_user,
            'branch_id'=>Auth::user()->branch_id,
        ]);
        return redirect()->route('expence.index')->with('flash','success');
    }

    //xepense type

    function getExpenseType()
    {
        $expense=Expense::Branch()->get();
        return response()->json($expense);
    }

    function destroy($id)
    {
        $expense=Expence::destroy($id);
        return redirect()->back()->with('flash','success');
    }

    

    
}
