<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{

    public function register(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:admins',
        'password' => 'required|string|min:6|confirmed',
       
    ]);
    if ($validator->fails())
    {
        return response(['errors'=>$validator->errors()->all()], 422);
    }
    $request['password']=Hash::make($request['password']);
    $request['remember_token'] = Str::random(10);

    $user = Admin::create($request->toArray());
    $token = $user->createToken('CRUD_Token_API')->accessToken;
    $response = [['token' => $token, 'message' => 'You have been successfully admin register .']];
    return response($response, 200);
}
    

public function login()
{
    $validatedData = request()->validate([
        'email' => 'required',
        'password' => 'required|min:6'
    ]);
  
    $user = Admin::where('email', request()->email)->first();

    if (!Hash::check(request()->password, $user->password)) {
   
        return response()->json(['error' => 'Unauthorized'], 401);
    }
   
    Auth::login($user);
    $tokenResult = $user->createToken('CRUD_Token_API')->accessToken;
   
    return response()->json([['token' =>  $tokenResult, 'message' => 'You have been successfully admin login.']], 200);
}
}
