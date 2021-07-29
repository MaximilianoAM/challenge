<?php

namespace App\Http\Requests;

use App\Models\Account;
use App\Rules\MaximumUserAccountsRule;
use App\Rules\ValidCnpjRule;
use App\Rules\ValidCpfRule;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

/**
 * Class StoreOrUpdateAccountRequest
 * @package App\Http\Requests
 */
class StoreOrUpdateAccountRequest extends FormRequest
{
    /**
     * @throws Exception
     */
    public function loadData(): void
    {
        $this->addFields([
            'owner_user_id',
            'type',
            'agency',
            'number',
            'digit',
            'name',
            'cpf',
            'cnpj',
            'trading_name',
            'corporate_name',
        ]);
    }

    /**
     * @throws Exception
     */
    public function loadRules(): void
    {
        /** @var Account|null $account */
        $account = $this->route('account');

        $this->addRules([
            'owner_user_id' => ['required', 'integer', 'exists:users,id'],

            'type' => ['required', 'string', 'in:' . Account::TYPE_COMPANY . ',' . Account::TYPE_PERSON,
                new MaximumUserAccountsRule(request()->get('owner_user_id'), $account)
            ],

            'agency' => ['required', 'integer'],

            'number' => ['required', 'integer'],

            'digit' => ['required', 'integer', 'min:1', 'max:9'],

            'name' => ['required_if:type,' . Account::TYPE_PERSON, 'string'],

            'cpf' => ['required_if:type,' . Account::TYPE_PERSON, 'string', 'min:14', 'max:14',
                new ValidCpfRule(),
                Rule::unique('person_accounts', 'cpf')->where(function (Builder $query) use ($account) {
                    if ($account && $account->personAccount) {
                        $query->where('id', '<>', $account->personAccount->id);
                    }
                }),
            ],

            'cnpj' => ['required_if:type,' . Account::TYPE_COMPANY, 'string', 'min:18', 'max:18',
                new ValidCnpjRule(),
                Rule::unique('company_accounts', 'cnpj')->where(function (Builder $query) use ($account) {
                    if ($account && $account->companyAccount) {
                        $query->where('id', '<>', $account->companyAccount->id);
                    }
                }),
            ],

            'trading_name' => ['required_if:type,' . Account::TYPE_COMPANY, 'string'],

            'corporate_name' => ['required_if:type,' . Account::TYPE_COMPANY, 'string'],
        ]);
    }
}
