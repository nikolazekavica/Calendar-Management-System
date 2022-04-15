<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 15:01
 */

namespace App\Http\Services\Concrete\User;

use App\Http\Repositories\Abstraction\UserRepositoryInterface;
use App\Http\Services\Abstraction\UserInterfaces\UserServiceInterface;
use App\Http\Traits\DateTimeTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    use DateTimeTrait;

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $request
     * @return array
     */
    public function store(array $request): array
    {
        $request['verification_code'] = Hash::make($request['username']);

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
     * @return Collection
     */
    public function search(array $data): Collection
    {
        return $this->userRepository->search($data);
    }
}