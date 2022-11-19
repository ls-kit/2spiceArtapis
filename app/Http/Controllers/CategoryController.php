<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use jeremykenedy\LaravelRoles\Models\Role;
use Validator;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Showing Category Management';
        $empty_message = 'No Category is available.';
        $categories = Category::get();
        $roles = Role::all();
        return View('backend.admin.category.index', compact('categories', 'roles', 'page_title', 'empty_message'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'Create A New Video';
        $categories = Category::all();
        // $countries = Country::all();
        return view('backend.admin.category.create', compact('page_title', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
            'description' => 'required',
            
        ]);
         
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->description = $request->description;
        $category->status = $request->status;
        $category->save();
        return redirect()->route('categories')->with('create', 'Category has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = 'Update Category';
        $category = Category::find($id);
        return view('backend.admin.category.edit', compact('page_title', 'category'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id)->update([
            "category_name" => $request->category_name,
            "description" => $request->description,
            "status" => $request->status,
            
        ]);
        return redirect()->route('categories')->with('update', 'Category has been update successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::findOrFail($id)->delete(); 

        return redirect()->back()->with('delete', 'Category has been delete successfully.');
    }
}
