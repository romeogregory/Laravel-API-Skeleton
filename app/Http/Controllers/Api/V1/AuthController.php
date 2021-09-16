<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\CustomerCreateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Customer;

class AuthController extends BaseController
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

        return $this->sendResponse(['token' => $token], 'Successfully registered.');

    }

    public function login(Request $request)
    {
        $data = [
            'email'     => $request->email,
            'password'  => $request->password
        ];
 
        if (Auth::attempt($data)) {
            $token = Auth::user()->createToken('LaravelAuthApp')->accessToken;

            return $this->sendResponse(['token' => $token], 'Successfully logged in.');

        } else {
            if (!Customer::where('email', '=', $data['email'])->exists()) {
                return $this->sendError('Unauthorised.', ['error'=>'Email does not exist']);
             }
             else
             {
                return $this->sendError('Unauthorised.', ['error'=>'Password does not match with the given Email']);
             }
            

        }
    }

    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();
        return $this->sendResponse(['user' => $user], 'Successfully logged out.');

    }

    public function getAuthCustomer()
    {
        $customer = Auth::guard('api')->user();
        return $this->sendResponse(['customer' => $customer], 'Customer fetched.');

    }

}
