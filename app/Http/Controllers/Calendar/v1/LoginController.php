<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 15.4.2022.
 * Time: 17:05
 */
namespace App\Http\Controllers\Calendar\v1;

use App\Helpers\CalendarResponse;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Services\Abstraction\User\LoginServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
    }

    public function logout(Request $request)
    {
        $this->loginService->logout($request);

        return CalendarResponse::success(
            "User successfully logout.",
            Response::HTTP_OK
        );
    }


}