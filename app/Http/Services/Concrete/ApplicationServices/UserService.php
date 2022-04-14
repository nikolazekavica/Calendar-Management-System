<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 15:01
 */

namespace App\Http\Services\Concrete\ApplicationServices;

use App\Http\Repositories\Abstraction\UserRepositoryInterface;
use App\Http\Requests\User\RegistrationUserRequest;
use App\Http\Services\Abstraction\ApplicationServiceInterfaces\UserServiceInterface;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function store(RegistrationUserRequest $storeRequest):void
    {
        $this->userRepository->store($storeRequest->all());
    }
}