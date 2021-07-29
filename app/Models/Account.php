<?php

namespace App\Models;

use App\Helpers\Models\FullTextSearch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class CompanyAccount
 * @package App\Models
 * @property int $id
 * @property string $type
 * @property string $agency
 * @property string $number
 * @property string $digit
 * @property float $balance
 * @property string $created_at
 * @property string $updated_at
 * @property-read PersonAccount $personAccount
 * @property-read CompanyAccount $companyAccount
 */
class Account extends Model
{
    use FullTextSearch;

    const TYPE_COMPANY = 'COMPANY';
    const TYPE_PERSON = 'PERSON';

    protected $casts = [
        'balance' => 'float',
    ];

    protected $fillable = [
        'agency',
        'number',
        'digit',
        'balance',
    ];

    /**
     * @return HasOne
     */
    public function personAccount(): HasOne
    {
        return $this->hasOne(PersonAccount::class);
    }

    /**
     * @return HasOne
     */
    public function companyAccount(): HasOne
    {
        return $this->hasOne(CompanyAccount::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @return User
     */
    public function ownerUser(): User
    {
        $user = null;
        switch ($this->type) {
            case self::TYPE_COMPANY:
                $user = $this->companyAccount->ownerUser;
                break;

            case self::TYPE_PERSON:
                $user = $this->personAccount->ownerUser;
                break;
        }
        return $user;
    }

    /**
     * @return string[]
     */
    public function useColumnsToSearch(): array
    {
        return [
            'agency',
            'number',
            'digit',
        ];
    }
}
