<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 14:24
 */

namespace App\Http\Controllers;

use App\Helpers\CalendarResponse;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Services\Abstraction\ApplicationServiceInterfaces\UserServiceInterface;
use Illuminate\Http\Response;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function store(UserStoreRequest $request)
    {
        $this->userService->store($request);

        return CalendarResponse::success(
            "User successfully inserted.",
            Response::HTTP_CREATED
        );
    }
}