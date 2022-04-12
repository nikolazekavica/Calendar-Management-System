<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 22:55
 */

namespace App\Http\Repositories\Abstraction;


interface UserRepositoryInterface
{
    public function store(array $data):void;
}