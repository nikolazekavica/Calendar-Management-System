<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 15.4.2022.
 * Time: 17:48
 */

namespace App\Http\Services\Concrete\User;

use App\Http\Services\Abstraction\User\AuthServiceInterface;
use App\Http\Services\Abstraction\User\LoginServiceInterface;
use App\Http\Services\Abstraction\User\UserServiceInterface;
use Illuminate\Http\Request;

class LoginService implements LoginServiceInterface
{
    protected $authService;
    protected $userService;

    public function __construct(AuthServiceInterface $authService, UserServiceInterface $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    public function login($data)
    {
        $user = $this->userService->getByEmailAndPassword($data);
        return $this->authService->createToken($user);
    }

    public function logout(Request $request)
    {
        $this->authService->revokeToken($request);
    }
}