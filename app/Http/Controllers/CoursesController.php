<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Admin;


class CoursesController extends Controller
{

    
public function store(Request $request){


 
    $request->validate([
    'name' => 'required',
    'video' => 'required|mimes:mpeg,mp4,webm,3gp,mov,jpg',
    'category_id' => 'required',
   
    ]);

    if($request->hasFile('image')) {
        $file = $request->file('image');
        $fileName = time().'_'.$request->file->getClientOriginalName();
        $file->move('uploads', $fileName);


    $fileUpload =  Courses::create([
        'name' => $request->name,
        'video' => $request->video,
        'category_id' => $request->category_id,

    ]);


    

        return response()->json([
            "success" => true,
            "message" => "Course created successfully.",
            "data" => $fileUpload
        ]);
    }

}


public function index(){
   
    $course = Courses::all();
     return response()->json([
        "success" => true,
        "message" => "course List",
        "data" => $course
        ]);
}



}
