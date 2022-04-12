<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 23:03
 */

namespace App\Providers;

use App\Http\Repositories\Abstraction\UserRepositoryInterface;
use App\Http\Repositories\Concrete\UserRepository;
use App\Http\Services\Abstraction\UserServiceInterface;
use App\Http\Services\Concrete\UserService;
use Carbon\Laravel\ServiceProvider;

class CalendarServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }
}