<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Validator;
use App\User;
use Auth;

class AuthController extends Controller
{
     public function signup(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    		'name' => 'required|string|max:255',
    		'email' => 'required|string|email|max:255|unique:users',
    		'password' => 'required|string|min:6|confirmed',
    	]);

    	if($validator->fails())
    		return response(['errors' => $validator->errors()->all()], 422);

    	$user = new User([
    		'name' => $request->name,
    		'email' => $request->email,
    		'password' => Hash::make($request->password)
    	]);

    	$user->save();

    	return response()->json(['message' => 'Successfully created user!']);
    }

    public function login(Request $request)
    {
    	$user = User::where('email', $request->email)->first();

    	if ($user) 
    	{
    		if (Hash::check($request->password, $user->password)) 
    		{
    			$token = $user->createToken('Laravel User Client')->accessToken;
    			return response()->json(['token' => $token], 200);
    		}
    		else
    		{
    			return response()->json(['error' => 'Password or Email missmatch'], 422);
    		}
    	}

    	return response()->json(["error" => 'The user doest exist'], 422);
    }
}
