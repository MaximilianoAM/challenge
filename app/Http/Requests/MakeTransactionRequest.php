<?php

namespace App\Http\Requests;

use App\Models\Transaction;
use Exception;

/**
 * Class MakeTransactionRequest
 * @package App\Http\Requests
 */
class MakeTransactionRequest extends FormRequest
{
    /**
     * @throws Exception
     */
    public function loadData(): void
    {
        $this->addFields([
            'type',
            'description',
            'value',
        ]);
    }

    /**
     * @throws Exception
     */
    public function loadRules(): void
    {
        $validTypes = implode(',', [
            Transaction::TYPE_BILL_PAYMENT,
            Transaction::TYPE_DEPOSIT,
            Transaction::TYPE_TRANSFER,
            Transaction::TYPE_CELL_PHONE_RECHARGE,
            Transaction::TYPE_CREDIT_PURCHASE,
        ]);

        if ($this->get('type') == Transaction::TYPE_DEPOSIT) {
            $rule = 'min:1';
        } else {
            $rule = 'max:-1';
        }

        $this->addRules([
            'type' => ['required', 'string', 'in:' . $validTypes],
            'value' => ['required', 'numeric', $rule],
            'description' => ['nullable', 'string', 'max:50'],
        ]);
    }
}
