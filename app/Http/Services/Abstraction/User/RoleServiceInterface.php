<?php

namespace App\Http\Services\Abstraction\User;

/**
 * Class RoleServiceInterface
 *
 * @package App\Http\Services\Abstraction\User
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
interface RoleServiceInterface
{
    /**
     * Get all roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all();
}