<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\CustomerCreateRequest;
use App\Http\Requests\CustomerEditRequest;
use App\Models\Customer;
use App\Http\Resources\Customer as CustomerResource;

class CustomerController extends BaseController
{
    public function index()
    {
        $customers = Customer::all();
        return $this->sendResponse(CustomerResource::collection($customers), 'Customers fetched.');
    }
    
    public function store(CustomerCreateRequest $request)
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

    public function show($id)
    {
        $customer = Customer::find($id);
        if (is_null($customer)) {
            return $this->sendError('Customer not found.');
        }

        return $this->sendResponse(['customer' => new CustomerResource($customer)], 'Customer retrieved successfully.');

    }

    public function update(CustomerEditRequest $request, $id)
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

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return $this->sendResponse([], 'Customer deleted successfully.');

    }
}
