<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Traits\ImageTrait;
use App\Models\Brand;

use App\Http\Requests\BrandRequest;
class BrandController extends Controller {
   
   use ImageTrait;
    
    public function index() {

        $brands = Brand::brands();
        return view('panel.brands.index', compact('brands'));

    }

    public function create() {
        
        return view('panel.brands.create');

    }

    public function store(BrandRequest $request) {
        
       
       if($request->hasfile('image'))
       {
        $data = array_merge($request->validated(),['brand_logo' => $this->image()??null]);
       }else{
        $data=$request->validated();
      }
        
       return \FormHelper::createEloquent(new Brand, branch_id($data));
        

    }

    public function edit($id) {

        $brand = Brand::Branch()->findOrFail($id);
        
        return view('panel.brands.edit', ['brand' => $brand]);

    }

    public function update(BrandRequest $request, $id) {
        
        if($request->hasfile('image'))
       {
        $data = array_merge($request->validated(),['brand_logo' => $this->image()??null]);
       }else
       {
         $data=$request->validated();
      
       }
        
       return \FormHelper::updateEloquent(new Brand,$id, branch_id($data));
       

    }

    public function destroy($id) {
        
        Brand::destroy($id); 

        return redirect()->route('brands.index')->with('flash', 'success');

    }

}
