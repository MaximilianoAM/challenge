<?php

namespace App\Rules;

use App\Models\Account;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Lang;

class MaximumUserAccountsRule implements Rule
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Account
     */
    private $account;

    /**
     * MaximumUserAccountsRule constructor.
     * @param int|null $userId
     * @param Account|null $account
     */
    public function __construct(int $userId = null, Account $account = null)
    {
        $this->user = User::where('id', $userId)->first();
        $this->account = $account;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $passes = false;
        if ($attribute == 'type') {
            $accountType = '';
            switch ($value) {
                case Account::TYPE_COMPANY:
                    $accountType = 'companyAccount';
                    break;

                case Account::TYPE_PERSON:
                    $accountType = 'personAccount';
                    break;
            }

            if (!$accountType || !$this->user) {
                $passes = true;
            } else if (!$this->user->$accountType()->exists()) {
                $passes = true;
            } else if ($this->account) {
                $passes = $this->account->id == $this->user->$accountType->account_id;
            }
        }
        return $passes;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return Lang::get('validation.custom.type.'.self::class);
    }
}
