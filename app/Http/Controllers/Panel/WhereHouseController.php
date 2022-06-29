<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WhereHouse;
use App\Http\Requests\WhereHouseRequest;
class WhereHouseController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wherehouses=WhereHouse::Branch()->get();
        return view('panel.wherehouse.index',compact('wherehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('panel.wherehouse.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WhereHouseRequest $request)
    {
        // branch id Function is an helper function
        // this fuction add branch id to validated data
       return \FormHelper::createEloquent(new WhereHouse, branch_id($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $wherehouse=WhereHouse::findorfail($id);
        return view('panel.wherehouse.edit',compact('wherehouse'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=[
         'where_house_name'=>$request->where_house_name,
         'where_house_location'=>$request->where_house_location,
        ];  
         return \FormHelper::updateEloquent(new WhereHouse,$id, branch_id($data));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        WhereHouse::destroy($id);
        return redirect()->back();
    }
}

