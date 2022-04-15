<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 22:55
 */

namespace App\Http\Repositories\Abstraction;

use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function store(array $data):void;
    public function search(array $data):Collection;
    public function getByEmail(string $email):Collection;
    public function update(array $data, int $userId);
}