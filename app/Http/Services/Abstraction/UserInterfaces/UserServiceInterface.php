<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 22:59
 */

namespace App\Http\Services\Abstraction\UserInterfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    public function store(array $storeRequest):array;
    public function update(array $data, $userId): void;
    public function search(array $data): Collection;
    public function getByEmail(string $email): Collection;
}