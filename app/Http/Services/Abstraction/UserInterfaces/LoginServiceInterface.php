<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 14.4.2022.
 * Time: 18:18
 */

namespace App\Http\Services\Abstraction\UserInterfaces;

use App\Models\User;

interface LoginServiceInterface
{
    public function verificationUser(string $link):User;
    public function prepareVerificationData(array $data):array;

}