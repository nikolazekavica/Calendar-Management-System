<?php

namespace App\Http\Repositories\Concrete;

use App\Exceptions\CalendarErrorException;
use App\Http\Repositories\Abstraction\UserRepositoryInterface;
use App\Models\User;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserRepository
 *
 * @package App\Http\Repositories\Concret
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    protected $model;

    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Update user.
     *
     * @param array $data
     * @param int $userId
     *
     * @return void
     */
    public function update(array $data, int $userId)
    {
        $this->model->where('id', $userId)->update($data);
    }

    /**
     * Insert user.
     *
     * @param array $user
     *
     * @return void
     */
    public function store(array $user): void
    {
        $this->model->create($user);
    }

    /**
     * Get user by email and password
     *
     * @param array $params
     *
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws CalendarErrorException
     */
    public function getByEmailAndPassword(array $params): User
    {
        $user = $this->model
            ->newQuery()
            ->where('email', $params['email'])
            ->where('verification_status', 1)
            ->first();

        if (!$user) {
            throw new CalendarErrorException(
                'User account is not verified.',
                Response::HTTP_UNAUTHORIZED
            );
        }

        $validatePassword = Hash::check($params['password'], $user->getAttribute('password'));

        if (!$validatePassword) {
            throw new CalendarErrorException(
                'Incorrect password.',
                Response::HTTP_FORBIDDEN
            );
        }

        return $user;
    }

    /**
     * Get user by email
     *
     * @param string $email
     *
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function getByEmail(string $email): User
    {
        return $this->model->where('email', $email)->first();
    }
}