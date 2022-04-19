<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 15:08
 */

namespace App\Http\Repositories\Concrete;

use App\Exceptions\CalendarErrorException;
use App\Http\Repositories\Abstraction\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function update(array $data, int $userId)
    {
        $this->model->where('id', $userId)->update($data);
    }

    public function store(array $userData): void
    {
        $this->model->create($userData);
    }

    /**
     * @param array $params
     * @return User|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws CalendarErrorException
     */
    public function getByEmailAndPassword(array $params):User
    {
        $user = $this->model
            ->newQuery()
            ->where('email', $params['email'])
            ->where('verification_status',1)
            ->first();

        if(!$user) {
            throw new CalendarErrorException(
                'User account is not verified.',
                Response::HTTP_UNAUTHORIZED
            );
        }

        $validatePassword = Hash::check($params['password'], $user->getAttribute('password'));

        if(!$validatePassword){
            throw new CalendarErrorException(
                'Incorrect password.',
                Response::HTTP_FORBIDDEN
            );
        }

        return $user;
    }

    public function getByEmail(string $email): Collection
    {
        return $this->model->where('email', $email)->get();
    }
}