<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Auth;
class ExpenseTypeController extends Controller
{
    function index()
    {
        $expense=Expense::expenseType();
     
        return view('expense.expense_type.index',compact('expense'));
    }

   function create()
   {
    $expense_type=Expense::expenseType();
    return response()->json($expense_type);
   }
    function store(Request $req)
    {
        $req->validate([
            'expence_type' =>'required',
        ]);
          
    
      Expense::create([
        
         'expence_type' => $req->expence_type,
         'branch_id' =>Auth::user()->branch_id,
      ]);

      return response()->json('data added');
        
    }

    function edit($id)
    {
        $expense=Expense::findorfail($id);

        return view('expense.expense_type.edit',compact('expense'));
    }


    function   Update(Request $request,$id)
    {
       
      $data=branch_id($request->only('expence_type'));

      return \FormHelper::updateEloquent(new Expense, $id, $data);
    
    }

    function destroy($id)
    {
         Expense::destroy($id);
        return redirect()->back()->with('flash','success');

    }
}
