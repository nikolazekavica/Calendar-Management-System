<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 22:59
 */

namespace App\Http\Services\Abstraction\ApplicationServiceInterfaces;

use App\Http\Requests\User\UserStoreRequest;

interface UserServiceInterface
{
    public function store(UserStoreRequest $storeRequest):void;
}