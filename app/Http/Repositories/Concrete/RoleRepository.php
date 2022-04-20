<?php

namespace App\Http\Repositories\Concrete;

use App\Http\Repositories\Abstraction\RoleRepositoryInterface;
use App\Models\Role;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class RoleRepository
 *
 * @package App\Http\Repositories\Concret
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class RoleRepository implements RoleRepositoryInterface
{
    /**
     * @var Role
     */
    protected $model;

    /**
     * RoleRepository constructor.
     *
     * @param Role $model
     */
    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    /**
     * Get all roles.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $availabilities = $this->model->all();
    }
}