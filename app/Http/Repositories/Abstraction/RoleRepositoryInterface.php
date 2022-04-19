<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 17.4.2022.
 * Time: 19:00
 */

namespace App\Http\Repositories\Abstraction;


use Illuminate\Database\Eloquent\Collection;

interface RoleRepositoryInterface
{
    public function all():Collection;

}