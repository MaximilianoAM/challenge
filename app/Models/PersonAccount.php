<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CompanyAccount
 * @package App\Models
 * @property int $id
 * @property int $owner_user_id
 * @property int $account_id
 * @property string $cpf
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property-read User $ownerUser
 * @property-read Account $account
 */
class PersonAccount extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'cpf',
        'name',
    ];

    /**
     * @return BelongsTo
     */
    public function ownerUser(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'owner_user_id'
        );
    }

    /**
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
