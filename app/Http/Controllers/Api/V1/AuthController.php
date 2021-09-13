<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerCreateRequest;
use Illuminate\Http\Request;
use App\Models\Customer;

class AuthController extends Controller
{
    public function register(CustomerCreateRequest $request)
    {
        $user = Customer::create([
            'firstname'                 => $request->firstname,
            'lastname'                  => $request->lastname,
            'insertion'                 => $request->insertion,
            'mobile'                    => $request->mobile,
            'driving_license_category'  => $request->driving_license_category,
            'drivers_license_number'    => $request->drivers_license_number,
            'username'                  => $request->username,
            'email'                     => $request->email,
            'password'                  => bcrypt($request->password)
        ]);
       
        $token = $user->createToken('LaravelAuthApp')->accessToken;
 
        return response()->json([
            'success'   => true,
            'token'     => $token
        ], 200);
    }

    public function login(Request $request)
    {
        $data = [
            'email'     => $request->email,
            'password'  => $request->password
        ];
 
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;
            return response()->json([
                'success' => true,
                'token' => $token,
                'test' => auth()->user()->firstname
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorised'
            ], 401);
        }
    }  
}
