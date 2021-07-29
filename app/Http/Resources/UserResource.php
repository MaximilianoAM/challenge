<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @package App\Http\Resources
 * @mixin User
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'cpf' => $this->cpf,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'company_account' => $this->companyAccount
                ? $this->companyAccount->account
                : null,

            'person_account' => $this->personAccount
                ? $this->personAccount->account
                : null,
        ];
        return $data;
    }
}
