<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Customer extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                        => $this->id,
            'firstname'                 => $this->firstname,
            'lastname'                  => $this->lastname,
            'insertion'                 => $this->insertion,
            'mobile'                    => $this->mobile,
            'driving_license_category'  => $this->driving_license_category,
            'drivers_license_number'    => $this->drivers_license_number,
            'username'                  => $this->username,
            'email'                     => $this->email,
            'created_at'                => $this->created_at->format('m/d/Y'),
            'updated_at'                => $this->updated_at->format('m/d/Y'),
        ];
    }
}
