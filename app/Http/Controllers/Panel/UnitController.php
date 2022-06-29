<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Http\Requests\UnitRequest;
use App\Models\Unit;

class UnitController extends Controller {
    
    public function index() 
    {

        $units =Unit::Branch()->get(); 
        return view('panel.units.index', compact('units'));
    }

    public function create() {

        return view('panel.units.create');

    }

    public function store(UnitRequest $request)
     {
        
      // branch_id is a global function
      // which adds branch id to request data
      $query = Unit::create(branch_id($request->validated()));
       return redirect()->route('units.index')->with('flash', 'success');
    }

    public function edit($id) {

        $unit = Unit::Branch()->findOrFail($id);
        return view('panel.units.edit', ['unit' => $unit]);

    }

    public function update(UnitRequest $request, $id)
     {
        
        $unit = Unit::where('id',$id)->update($request->validated());
         return redirect()->route('units.index')->with('flash', 'success');       
     }

    public function destroy($id) 
    {
        
        Unit::destroy($id);        
        return redirect()->route('units.index')->with('flash', 'success');
    }

}
