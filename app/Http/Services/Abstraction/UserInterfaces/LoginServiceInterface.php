<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 15.4.2022.
 * Time: 17:09
 */

namespace App\Http\Services\Abstraction\UserInterfaces;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface LoginServiceInterface
{
    public function login(array $data);
    public function logout(Request $data);
}