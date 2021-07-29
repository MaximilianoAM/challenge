<?php

namespace App\Http\Resources;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AccountResource
 * @package App\Http\Resources
 * @mixin Account
 */
class AccountResource extends JsonResource
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
            'type' => $this->type,
            'agency' => $this->agency,
            'number' => $this->number,
            'digit' => $this->digit,
            'balance' => $this->balance,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];

        if ($this->companyAccount) {
            $data = array_merge($data, [
                'cnpj' => $this->companyAccount->cnpj,
                'corporate_name' => $this->companyAccount->corporate_name,
                'trading_name' => $this->companyAccount->trading_name,
            ]);
        } else {
            $data = array_merge($data, [
                'cpf' => $this->personAccount->cpf,
                'name' => $this->personAccount->name,
            ]);
        }

        $data['owner_user'] = $this->ownerUser();

        $data['transactions'] = $this->transactions;

        return $data;
    }
}
