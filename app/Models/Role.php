<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Roles
 *
 * @method static Builder create(array $attributes = [])
 *
 * @package App\Models
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}