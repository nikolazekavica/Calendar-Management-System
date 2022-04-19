<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 22:55
 */

namespace App\Http\Repositories\Abstraction;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function store(array $data):void;
    public function getByEmailAndPassword(array $data):User;
    public function getByEmail(string $email):Collection;
    public function update(array $data, int $userId);
}