<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 17.4.2022.
 * Time: 18:49
 */

namespace App\Http\Services\Concrete\User;


use App\Http\Repositories\Concrete\RoleRepository;
use App\Http\Services\Abstraction\User\RoleServiceInterface;

class RoleService implements RoleServiceInterface
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function all()
    {
        return $this->roleRepository->all();
    }
}