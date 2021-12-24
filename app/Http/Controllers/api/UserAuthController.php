<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function register(Request $request)
    {
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
    
    ]);
    if ($validator->fails())
    {
        return response(['errors'=>$validator->errors()->all()], 422);
    }
    $request['password']=Hash::make($request['password']);
    $request['remember_token'] = Str::random(10);

    $user = User::create($request->toArray());
    $token = $user->createToken('CRUD_Token_API')->accessToken;
    $response = [['token' => $token, 'message' => 'You have been successfully register.']];
    return response($response, 200);
}

public function login(Request $request)

{
    $login_credentials=[
        'email'=>$request->email,
        'password'=>$request->password,
    ];
    if(auth()->attempt($login_credentials)){
       
        $user_login_token= auth()->user()->createToken('CRUD_Token_API')->accessToken;
       
        return response()->json([['token' =>  $user_login_token, 'message' => 'You have been successfully login.']], 200);
    }
    else{
    
        return response()->json(['error' => 'UnAuthorised Access'], 401);
    }
}


public function logout(Request $request)
{
    $accessToken = auth()->user()->token();
    $token= $request->user()->tokens->find($accessToken);
    $token->revoke();
    return response([['token' =>  $user_login_token,'message' => 'You have been successfully logged out.']], 200);
}


public function getUser() {
    $user = User::all();
    return response()->json(['success' => $user]); 
    }

}
