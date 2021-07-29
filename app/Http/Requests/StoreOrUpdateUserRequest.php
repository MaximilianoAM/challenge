<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\ValidCpfRule;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

/**
 * Class StoreOrUpdateUserRequest
 * @package App\Http\Requests
 */
class StoreOrUpdateUserRequest extends FormRequest
{
    /**
     * @throws Exception
     */
    public function loadData(): void
    {
        $this->addFields([
            'name',
            'cpf',
            'phone_number',
            'email',
            'password',
        ]);
    }

    /**
     * @throws Exception
     */
    public function loadRules(): void
    {
        /** @var User|null $user */
        $user = $this->route('user');

        $this->addRules([
            'name' => ['required', 'string'],

            'cpf' => ['required', 'string', 'min:14', 'max:14',
                new ValidCpfRule(),
                Rule::unique('users', 'cpf')->where(function (Builder $query) use ($user) {
                    if ($user) {
                        $query->where('id', '<>', $user->id);
                    }
                }),
            ],

            'email' => ['required', 'email',
                Rule::unique('users', 'email')->where(function (Builder $query) use ($user) {
                    if ($user) {
                        $query->where('id', '<>', $user->id);
                    }
                }),
            ],

            'phone_number' => ['required', 'string'],

            'password' => [$user ? 'nullable' : 'required', 'string', 'min:6'],
        ]);
    }
}
