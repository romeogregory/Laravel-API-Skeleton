<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCreateRequest;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function register(UserCreateRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
       
        $token = $user->createToken('LaravelAuthApp')->accessToken;
 
        return response()->json([
            'success' => true,
            'token' => $token
        ], 200);
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json([
                'success' => true,
                'token' => $token
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorised'
            ], 401);
        }
    }  
}
