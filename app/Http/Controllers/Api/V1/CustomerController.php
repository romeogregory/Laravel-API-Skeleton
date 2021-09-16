<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Resources\Customer as CustomerResource;

class CustomerController extends BaseController
{
    public function index()
    {
        $customers = Customer::all();
        return $this->sendResponse(CustomerResource::collection($customers), 'Customers fetched.');
    }
}
