<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 15:01
 */

namespace App\Http\Services\Concrete\User;

use App\Http\Repositories\Abstraction\UserRepositoryInterface;
use App\Http\Repositories\Concrete\UserRepository;
use App\Http\Services\Abstraction\User\UserServiceInterface;
use App\Http\Traits\DateTimeTrait;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    use DateTimeTrait;

    private static $instance = null;

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new UserService(new UserRepository(new User()));
        }
        return self::$instance;
    }

    /**
     * @param array $request
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
     * @param array $data
     * @param $userId
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
     * @param string $email
     * @return Collection
     */
    public function getByEmail(string $email): Collection
    {
        return $this->userRepository->getByEmail($email);
    }

    /**
     * @param array $data
     * @return \App\Models\User
     */
    public function getByEmailAndPassword(array $data): User
    {
        return $this->userRepository->getByEmailAndPassword($data);
    }
}