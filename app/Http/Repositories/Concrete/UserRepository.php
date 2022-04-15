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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
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

    public function search(array $params):Collection
    {
        $query = $this->model->newQuery();

        foreach($params as $key => $value){
            $query->where($key, $value);
        }

        return $query->get();
    }

    public function getByEmail(string $email):Collection
    {
        return $this->model->where('email', $email)->get();
    }
}