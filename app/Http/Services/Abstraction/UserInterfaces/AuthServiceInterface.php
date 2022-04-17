<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 15.4.2022.
 * Time: 18:17
 */

namespace App\Http\Services\Abstraction\UserInterfaces;

use App\Models\User;

interface AuthServiceInterface
{
    public function createToken(User $user);
    public function removeToken(array $data);
    public function refreshToken(array $data);
    public function validateToken(array $data);
}