<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 15:01
 */

namespace App\Http\Services\Concrete;

use App\Http\Repositories\Abstraction\UserRepositoryInterface;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Services\Abstraction\UserServiceInterface;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function store(UserStoreRequest $storeRequest):void
    {
        $this->userRepository->store($storeRequest->all());
    }
}