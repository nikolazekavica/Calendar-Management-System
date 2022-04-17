<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 15.4.2022.
 * Time: 17:05
 */
namespace App\Http\Controllers\Calendar\v1;

use App\Http\Requests\User\LoginUserRequest;
use App\Http\Services\Abstraction\UserInterfaces\LoginServiceInterface;
use Illuminate\Http\Request;

class LoginController
{
    private $loginService;

    public function __construct(LoginServiceInterface $loginService)
    {
        $this->loginService = $loginService;
    }

    public function login(LoginUserRequest $request)
    {
        return $this->loginService->login($request->all());

/*        return CalendarResponse::success(
            "Availabilities successfully returned.",
            Response::HTTP_CREATED,
            $token
        );*/
    }

    public function logout(Request $request)
    {
        return $this->loginService->logout($request);

        /*        return CalendarResponse::success(
                    "Availabilities successfully returned.",
                    Response::HTTP_CREATED,
                    $token
                );*/
    }


}