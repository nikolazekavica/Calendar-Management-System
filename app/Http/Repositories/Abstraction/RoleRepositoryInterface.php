<?php

namespace App\Http\Repositories\Abstraction;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class RoleRepositoryInterface
 *
 * @package App\Http\Services\Abstraction\Availability
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
interface RoleRepositoryInterface
{
    /**
     * Get all roles.
     *
     * @return Collection
     */
    public function all(): Collection;

}