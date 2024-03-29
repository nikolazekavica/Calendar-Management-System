<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 *
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Builder create(array $attributes = [])
 * @method public Builder update(array $values)
 *
 * @package App\Models
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;

    protected $table = 'users';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'username',
        'password',
        'first_name',
        'last_name',
        'email',
        'verification_code',
        'verification_status',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'verification_code',
        'verification_status',
        'role_id',
        'created_at',
        'updated_at'
    ];

    /**
     * Relationship to the User table
     *
     */
    public function availability()
    {
        return $this->hasMany(Availability::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Find the user instance for the given username.
     * Check does user verified.
     *
     * @param  string $username
     * @return Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Validate the password of the user for the Passport password grant.
     *
     * @param  string $password
     * @return bool
     */
    public function validateForPassportPasswordGrant($password)
    {
        return $this->password;
    }
}
