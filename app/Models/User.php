<?php

namespace App\Models;

use App\Helpers\Models\FullTextSearch;
use App\Http\Resources\ModelResource;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * @package App\Models
 * @property int $id
 * @property string $cpf
 * @property string $name
 * @property string $phone_number
 * @property string $email
 * @property string $password
 * @property string $created_at
 * @property string $updated_at
 * @property-read PersonAccount $personAccount
 * @property-read CompanyAccount $companyAccount
 */
class User extends Authenticatable
{
    use Notifiable, FullTextSearch;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'cpf', 'phone_number', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @return HasOne
     */
    public function personAccount(): HasOne
    {
        return $this->hasOne(
            PersonAccount::class,
            'owner_user_id'
        );
    }

    /**
     * @return HasOne
     */
    public function companyAccount(): HasOne
    {
        return $this->hasOne(
            CompanyAccount::class,
            'owner_user_id'
        );
    }

    public function getResource(): JsonResource
    {
        return new ModelResource(self::class);
    }

    public function useColumnsToSearch(): array
    {
        return [
            'name',
            'cpf',
        ];
    }
}
