<?php

namespace App\Http\Services\Concrete\User;

use App\Http\Repositories\Abstraction\UserRepositoryInterface;
use App\Http\Repositories\Concrete\UserRepository;
use App\Http\Services\Abstraction\User\UserServiceInterface;
use App\Http\Traits\DateTimeTrait;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 *
 * @package App\Http\Services\Concrete\User
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class UserService implements UserServiceInterface
{
    use DateTimeTrait;

    /**
     * @var UserService
     */
    private static $instance = null;

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * UserService constructor
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get instance of UserService
     *
     * @return UserService
     */
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new UserService(new UserRepository(new User()));
        }
        return self::$instance;
    }

    /**
     * Insert user.
     *
     * @param array $request
     *
     * @return array
     */
    public function store(array $request): array
    {
        $request['verification_code'] = Hash::make($request['username']);
        $request['password']          = Hash::make($request['password']);

        $this->userRepository->store($request);

        return $request;
    }

    /**
     * Update user.
     *
     * @param array $data
     * @param $userId
     *
     * @return void
     */
    public function update(array $data, $userId): void
    {
        $this->userRepository->update(
            $data,
            $userId
        );
    }

    /**
     * Get user by email
     *
     * @param string $email
     *
     * @return User
     */
    public function getByEmail(string $email): User
    {
        return $this->userRepository->getByEmail($email);
    }

    /**
     * Get user by email an password
     *
     * @param array $request
     *
     * @return \App\Models\User
     */
    public function getByEmailAndPassword(array $request): User
    {
        return $this->userRepository->getByEmailAndPassword($request);
    }
}