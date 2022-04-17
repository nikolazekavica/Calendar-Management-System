<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 14.4.2022.
 * Time: 18:18
 */

namespace App\Http\Services\Abstraction\UserInterfaces;

use App\Models\User;

interface RegistrationServiceInterface
{
    public function verify(string $link):User;
    public function prepareVerificationEmailData(array $data):array;

}