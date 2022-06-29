<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
class CategoryController extends Controller {

    public function index() {

        $categories = Category::categories();
 
        return view('panel.categories.index', compact('categories'));

    }

    public function create() {

        return view('panel.categories.create');

    }

    public function store(CategoryRequest $request) {

      return \FormHelper::createEloquent(new Category, branch_id($request->validated()));

    }

    public function edit($id) {

        $category = Category::Branch()->findOrFail($id);
        
        return view('panel.categories.edit', compact('category'));

    }

    public function update(CategoryRequest $request, $id) {

        
        return \FormHelper::updateEloquent(new Category,$id, branch_id($request->validated()));

    }

    public function destroy($id) {

        Category::destroy($id);        

        return redirect()->route('categories.index')->with('flash', 'success');

    }

}
