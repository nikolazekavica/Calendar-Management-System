<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 17.4.2022.
 * Time: 18:59
 */

namespace App\Http\Repositories\Concrete;


use App\Http\Repositories\Abstraction\RoleRepositoryInterface;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository implements RoleRepositoryInterface
{
    protected $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function all():Collection
    {
        return $availabilities = $this->model->all();
    }
}