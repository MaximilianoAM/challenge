<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Transaction
 * @package App\Models
 * @property int $id
 * @property int $account_id
 * @property string $type
 * @property string $description
 * @property int $value
 * @property string $created_at
 * @property string $updated_at
 * @property-read Account $account
 */
class Transaction extends Model
{
    const TYPE_BILL_PAYMENT = 'BILL_PAYMENT';
    const TYPE_DEPOSIT = 'DEPOSIT';
    const TYPE_TRANSFER = 'TRANSFER';
    const TYPE_CELL_PHONE_RECHARGE = 'CELL_PHONE_RECHARGE';
    const TYPE_CREDIT_PURCHASE = 'CREDIT_PURCHASE';

    protected $fillable = [
        'type',
        'description',
        'value',
    ];

    /**
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function useColumnsToSearch(): array
    {
        return [
            'type',
            'description',
        ];
    }
}
