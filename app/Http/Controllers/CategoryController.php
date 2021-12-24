<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorys = Category::all();

        return response()->json([
        "success" => true,
        "message" => "Product List",
        "data" => $categorys
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $user = Auth::guard('admin-api'); 
    
        $input = $request->all();
        $validator = Validator::make($input, [
        'title' => 'required',
        'description' => 'required',
       
        ]);

        if($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);      
        }

        $category = Category::create([
            'title' => $request->title,
            'description' =>$request->description,
        ]);
        return response()->json([
        "success" => true,
        "message" => "Category created successfully.",
        "data" => $category
    ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        return response()->json([
        "success" => true,
        "message" => "Category retrieved successfully.",
        "data" => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
        'title' => 'required',
        'description' => 'required'
        ]);
        if($validator->fails()){
            return response(['errors'=>$validator->errors()->all()], 422);      
        }
        $category->title = $input['title'];
        $category->description = $input['description'];
        $category->save();
        return response()->json([
        "success" => true,
        "message" => "Category updated successfully.",
        "data" => $category
]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
        "success" => true,
        "message" => "Category deleted successfully.",
        "data" => $category
        ]);
    }
}
