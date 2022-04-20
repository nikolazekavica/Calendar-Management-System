<?php

namespace App\Http\Services\Concrete\User;

use App\Http\Repositories\Abstraction\RoleRepositoryInterface;
use App\Http\Repositories\Concrete\RoleRepository;
use App\Http\Services\Abstraction\User\RoleServiceInterface;
use App\Models\Role;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class RoleService
 *
 * @package App\Http\Services\Concrete\User
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class RoleService implements RoleServiceInterface
{
    /**
     * @var RoleService
     */
    private static $instance = null;

    /**
     * @var RoleRepositoryInterface
     */
    protected $roleRepository;

    /**
     * RoleService constructor
     *
     * @param RoleRepositoryInterface $roleRepository
     */
    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Get instance of RoleService
     *
     * @return RoleService
     */
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new RoleService(new RoleRepository(new Role()));
        }
        return self::$instance;
    }

    /**
     * Get all roles.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(): Collection
    {
        return $this->roleRepository->all();
    }
}