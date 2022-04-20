<?php

namespace App\Http\Controllers\Calendar\v1;

use App\Helpers\CalendarResponse;
use App\Http\Requests\User\LoginUserRequest;
use App\Http\Services\Abstraction\User\LoginServiceInterface;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class LoginController
 *
 * @package App\Http\Controllers\Calendar\v1
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class LoginController extends Controller
{
    /**
     * @var LoginServiceInterface
     */
    private $loginService;

    /**
     * LoginController constructor.
     *
     * @param $loginService $service
     */
    public function __construct(LoginServiceInterface $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * Login user
     *
     * @param LoginUserRequest $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function login(LoginUserRequest $request)
    {
        return $this->loginService->login($request->all());
    }

    /**
     * Logout user
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->loginService->logout($request);

        return CalendarResponse::success(
            "User successfully logout.",
            Response::HTTP_OK
        );
    }
}