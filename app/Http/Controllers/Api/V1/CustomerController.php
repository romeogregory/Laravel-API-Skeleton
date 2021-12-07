<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\CustomerCreateRequest;
use App\Http\Requests\CustomerEditRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Http\Resources\Customer as CustomerResource;

class CustomerController extends BaseController
{
    public function index()
    {
        $user = Auth::guard('api')->user();

        if($user->isAbleTo(['customers-read']))
        {
            $customers = Customer::all();
            return $this->sendResponse(CustomerResource::collection($customers), 'Customers fetched.');
        }
        else
        {
            return $this->sendError('You need administrator rights to perform this action.');
        }
    }
    
    public function store(CustomerCreateRequest $request)
    {
        $user = Auth::guard('api')->user();

        if($user->isAbleTo(['customers-create']))
        {
            $customer = Customer::create([
                'firstname'                 => $request->firstname,
                'lastname'                  => $request->lastname,
                'username'                  => $request->username,
                'email'                     => $request->email,
                'password'                  => bcrypt($request->password)
            ]);
    
            return $this->sendResponse(['customer' => new CustomerResource($customer)], 'Customer created successfully.');
        }
        else
        {
            return $this->sendError('You need administrator rights to perform this action.');
        }


    }

    public function show($id)
    {
        $user = Auth::guard('api')->user();

        if($user->isAbleTo(['customers-read']))
        {
            $customer = Customer::find($id);
            if (is_null($customer)) {
                return $this->sendError('Customer not found.');
            }
    
            return $this->sendResponse(['customer' => new CustomerResource($customer)], 'Customer retrieved successfully.');
        }
        else
        {
            return $this->sendError('You need administrator rights to perform this action.');
        }


    }

    public function update(CustomerEditRequest $request, $id)
    {
        $user = Auth::guard('api')->user();

        if($user->isAbleTo(['customers-update']))
        {
            $customer = Customer::find($id);
            if (is_null($customer)) {
                return $this->sendError('Customer not found, update failed.');
            }
            else {
                $customer->firstname = $request->firstname;
                $customer->lastname = $request->lastname;
                $customer->email = $request->email;
                $customer->username = $request->username;
                $customer->save();
    
                return $this->sendResponse(new CustomerResource($customer), 'Customer updated successfully.');
            }
        }
        else
        {
            return $this->sendError('You need administrator rights to perform this action.');
        }


    }

    public function destroy(Customer $customer)
    {
        $user = Auth::guard('api')->user();

        if($user->isAbleTo(['customers-delete']))
        {
            $customer->delete();
            return $this->sendResponse([], 'Customer deleted successfully.');
        }
        else
        {
            return $this->sendError('You need administrator rights to perform this action.');
        }
        

    }
}
