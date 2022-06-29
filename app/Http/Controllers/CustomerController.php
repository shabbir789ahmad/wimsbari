<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Traits\ImageTrait;
use App\Http\Requests\CustomerRequest;
use Auth;
class CustomerController extends Controller
{
   use ImageTrait;
    public function index()
    {
        $customers=Customer::all();
         return view('panel.customer.index',compact('customers'));
    }

      /**
        * Store a newly created resource in storage.
        *
        * @return Response
        */
   
    public function store(CustomerRequest $request)
    {
     
      if($request->hasfile('image'))
       {
        $data = array_merge($request->validated(),['customer_image' => $this->image()]);
       }else{
        $data=$request->validated();
      }
        Customer::create(branch_id($data));

        return response()->json('Customer Added Successfully');
    }

  

    /**
        * Display the specified resource.
        *
        * @param  int  $id
        * @return Response
        */
    public function show($id)
    {
        //
    }

    /**
        * Show the form for editing the specified resource.
        *
        * @param  int  $id
        * @return Response
        */
    public function edit($id)
    {
        $customer=Customer::findorfail($id);
        return view('panel.customer.update',compact('customer'));
    }

    /**
        * Update the specified resource in storage.
        *
        * @param  int  $id
        * @return Response
        */
    public function update($id,CustomerRequest $request)
    { 
        if($request->hasfile('image'))
       {
        $data = array_merge($request->validated(),['customer_image' => $this->image()]);
       }else{
        $data=$request->validated();
      }
        Customer::where('id',$id)->update(branch_id($data));
        return redirect()->route('customer.index')->with('success','Data Updated');
    }

    /**
        * Remove the specified resource from storage.
        *
        * @param  int  $id
        * @return Response
        */
    public function destroy($id)
    { 

        $customer=Customer::destroy($id);

        return redirect()->back()->with('success','Customer Data Deleted');
    }

    


    function accountData(Request $req)
    {
        $query=Customer::join('accounts','customers.id','=','accounts.customer_id')->select('customers.customer_name','accounts.account','accounts.paying_date','accounts.customer_id','accounts.id')->where('deleted_at', NULL);

        if($req->id==2)
        {
            $data=$query->where('account_type','0')->get();
        }else if($req->id==3)
        {
            $data=$query->where('account_type','1')->get();
        }

        return response()->json($data);
    }
}
