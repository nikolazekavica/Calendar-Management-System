<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 15.4.2022.
 * Time: 18:17
 */

namespace App\Http\Services\Abstraction\User;

use App\Models\User;
use Illuminate\Http\Request;

interface AuthServiceInterface
{
    public function createToken(User $user);
    public function revokeToken(Request $request);
}