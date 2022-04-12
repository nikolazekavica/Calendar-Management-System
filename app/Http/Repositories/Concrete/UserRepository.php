<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 15:08
 */

namespace App\Http\Repositories\Concrete;

use App\Http\Repositories\Abstraction\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function store(array $userData): void
    {
        $userData['password'] = Hash::make($userData['password']);
        $this->model->create($userData);
    }
}