<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Category;
use App\Models\SubCategory;
use Auth;
use App\Http\Requests\SubCategoryRequest;
class SubCategoryController extends Controller {

    public function index() {

        $sub_categories =SubCategory::Branch()->get();
                          
        return view('panel.sub_categories.index', compact('sub_categories'));

    }

    public function create() {

        $categories = Category::Branch()->get();

        return view('panel.sub_categories.create', compact('categories'));

    }

    public function store(SubCategoryRequest $request) {
     
        return \FormHelper::createEloquent(new SubCategory, branch_id($request->validated()));
       

    }

    public function edit($id) {

        $categories = Category::Branch()->get();
        $sub_category = SubCategory::findOrFail($id);
        
        return view('panel.sub_categories.edit', compact('categories', 'sub_category'));

    }

    public function update(SubCategoryRequest $request, $id) {

       
        return \FormHelper::updateEloquent(new SubCategory,$id, branch_id($request->validated()));
        
        
    }

    public function destroy($id) {

        SubCategory::destroy($id);        

        return redirect()->route('sub-categories.index')->with('flash', 'success');

    }

}
