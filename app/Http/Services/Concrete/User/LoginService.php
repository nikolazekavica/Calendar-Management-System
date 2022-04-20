<?php

namespace App\Http\Services\Concrete\User;

use App\Http\Services\Abstraction\User\AuthServiceInterface;
use App\Http\Services\Abstraction\User\LoginServiceInterface;
use App\Http\Services\Abstraction\User\UserServiceInterface;

use Illuminate\Http\Request;

/**
 * Class LoginService
 *
 * @package App\Http\Services\Concrete\User
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class LoginService implements LoginServiceInterface
{
    /**
     * @var AuthServiceInterface
     */
    protected $authService;

    /**
     * @var UserServiceInterface
     */
    protected $userService;

    /**
     * LoginService constructor
     *
     * @param AuthServiceInterface $authService
     * @param UserServiceInterface $userService
     */
    public function __construct(AuthServiceInterface $authService, UserServiceInterface $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    /**
     * Login user.
     *
     * @param $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function login($request)
    {
        $user = $this->userService->getByEmailAndPassword($request);
        return $this->authService->createToken($user);
    }

    /**
     * Logout user.
     *
     * @param Request $request
     *
     * @return void
     */
    public function logout(Request $request)
    {
        $this->authService->revokeToken($request);
    }
}