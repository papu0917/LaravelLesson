<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function add(Request $request)
    {
        return view('admin.category.create');
    }
    
    public function create(Request $request)
    {
        $category = new Category;
        $form = $request->all();
        
        unset($form['_token']);
        
        $category->fill($form);
        $category->save();
        
        return redirect('admin/category');
    }
    
    public function index(Request $request)
    {
        $cond_name = $request->cond_name;
        if ($cond_name != '') {
            $category = Category::where('name', $cond_name)->get();
        } else {
            $category = Category::all();
        }
        $posts = Category::paginate(5);

        return view('admin.category.index', ['posts' => $posts, 'category' => $category, 'cond_name' => $cond_name]);
    }
    
    public function edit(Request $request)
    {
        $category = Category::find($request->id);
        if (empty($category)) {
            abort(404);
        }
        
        return view('admin.category.edit', ['category_form' => $category]);
    }
    
    public function update(Request $request)
    {
        $this->validate($request, Category::$rules);
        $category = Category::find($request->id);
        $category_form = $request->all();
        unset($category_form['_token']);
        
        $category->fill($category_form)->save();
        
        return redirect('admin/category/');
    }
    
    public function delete(Request $request)
    {
        $category = Category::find($request->id);
        $category->delete();
        
        return redirect('admin/category/');
    }
}
