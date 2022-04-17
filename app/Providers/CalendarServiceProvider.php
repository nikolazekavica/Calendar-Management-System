<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 23:03
 */

namespace App\Providers;

use App\Http\Repositories\Abstraction\AvailabilityRepositoryInterface;
use App\Http\Repositories\Abstraction\UserRepositoryInterface;
use App\Http\Repositories\Concrete\AvailabilityRepository;
use App\Http\Repositories\Concrete\UserRepository;
use App\Http\Services\Abstraction\AvailabilityInterfaces\AvailabilityBuilderServiceInterface;
use App\Http\Services\Abstraction\AvailabilityInterfaces\AvailabilityServiceInterface;
use App\Http\Services\Abstraction\Common\HttpClientInterface;
use App\Http\Services\Abstraction\UserInterfaces\AuthServiceInterface;
use App\Http\Services\Abstraction\UserInterfaces\LoginServiceInterface;
use App\Http\Services\Abstraction\UserInterfaces\RegistrationServiceInterface;
use App\Http\Services\Abstraction\UserInterfaces\UserServiceInterface;
use App\Http\Services\Concrete\Availability\AvailabilityBuilderService;
use App\Http\Services\Concrete\Availability\AvailabilityService;
use App\Http\Services\Concrete\Common\HttpClient;
use App\Http\Services\Concrete\User\AuthService;
use App\Http\Services\Concrete\User\LoginService;
use App\Http\Services\Concrete\User\RegistrationService;
use App\Http\Services\Concrete\User\UserService;
use Carbon\Laravel\ServiceProvider;

class CalendarServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AvailabilityRepositoryInterface::class, AvailabilityRepository::class);

        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(AvailabilityServiceInterface::class, AvailabilityService::class);
        $this->app->bind(AvailabilityBuilderServiceInterface::class, AvailabilityBuilderService::class);

        $this->app->bind(RegistrationServiceInterface::class, RegistrationService::class);
        $this->app->bind(LoginServiceInterface::class, LoginService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(HttpClientInterface::class, HttpClient::class);
    }
}