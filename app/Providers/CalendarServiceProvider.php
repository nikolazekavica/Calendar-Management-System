<?php

namespace App\Providers;

use App\Http\Repositories\Abstraction\AvailabilityRepositoryInterface;
use App\Http\Repositories\Abstraction\RoleRepositoryInterface;
use App\Http\Repositories\Abstraction\UserRepositoryInterface;
use App\Http\Repositories\Concrete\AvailabilityRepository;
use App\Http\Repositories\Concrete\RoleRepository;
use App\Http\Repositories\Concrete\UserRepository;
use App\Http\Services\Abstraction\Availability\AvailabilityBuilderServiceInterface;
use App\Http\Services\Abstraction\Availability\AvailabilityServiceInterface;
use App\Http\Services\Abstraction\Common\HttpClientInterface;
use App\Http\Services\Abstraction\User\AuthServiceInterface;
use App\Http\Services\Abstraction\User\LoginServiceInterface;
use App\Http\Services\Abstraction\User\RegistrationServiceInterface;
use App\Http\Services\Abstraction\User\RoleServiceInterface;
use App\Http\Services\Abstraction\User\UserServiceInterface;
use App\Http\Services\Concrete\Availability\AvailabilityBuilderService;
use App\Http\Services\Concrete\Availability\AvailabilityService;
use App\Http\Services\Concrete\Common\HttpClientService;
use App\Http\Services\Concrete\User\AuthService;
use App\Http\Services\Concrete\User\LoginService;
use App\Http\Services\Concrete\User\RegistrationService;
use App\Http\Services\Concrete\User\RoleService;
use App\Http\Services\Concrete\User\UserService;

use Carbon\Laravel\ServiceProvider;

/**
 * Class AuthServiceProviders
 *
 * @package App\Providers
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class CalendarServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(AvailabilityServiceInterface::class, AvailabilityService::class);
        $this->app->bind(AvailabilityBuilderServiceInterface::class, AvailabilityBuilderService::class);
        $this->app->bind(RegistrationServiceInterface::class, RegistrationService::class);
        $this->app->bind(LoginServiceInterface::class, LoginService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(HttpClientInterface::class, HttpClientService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AvailabilityRepositoryInterface::class, AvailabilityRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
    }
}