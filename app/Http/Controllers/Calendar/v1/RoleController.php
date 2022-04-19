<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 17.4.2022.
 * Time: 18:47
 */

namespace App\Http\Controllers\Calendar\v1;

use App\Helpers\CalendarResponse;
use App\Http\Services\Abstraction\User\RoleServiceInterface;
use Illuminate\Http\Response;

class RoleController
{
    private $roleService;

    public function __construct(RoleServiceInterface $roleService)
    {
        $this->roleService = $roleService;
    }

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