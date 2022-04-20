<?php

namespace App\Http\Controllers\Calendar\v1;

use App\Helpers\CalendarResponse;
use App\Http\Services\Abstraction\User\RoleServiceInterface;

use Illuminate\Http\Response;

/**
 * Class RoleController
 *
 * @package App\Http\Controllers\Calendar\v1
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class RoleController
{
    /**
     * @var RoleServiceInterface
     */
    private $roleService;

    /**
     * RoleController constructor.
     *
     * @param RoleServiceInterface $roleService
     */
    public function __construct(RoleServiceInterface $roleService)
    {
        $this->roleService = $roleService;
    }

    /**
     * Get all roles
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $roles = $this->roleService->all();

        return CalendarResponse::success(
            "Roles successfully returned.",
            Response::HTTP_OK,
            $roles
        );
    }
}