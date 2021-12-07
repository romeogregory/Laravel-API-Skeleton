<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    /**
     * Assign a specific role to authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assignRole(Request $request)
    {
        $user = Auth::guard('api')->user();

        $assignedRole = $user->attachRole($request->role);

        if($assignedRole)
        {
            return $this->sendResponse([], 'Role assigned.');
        }
        else
        {
            return $this->sendError('Role has not been assigned to user.');
        }
    }
}
