<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 22:56
 */

namespace App\Http\Repositories\Abstraction;


use Illuminate\Database\Eloquent\Collection;

interface AvailabilityRepositoryInterface
{
    public function store(array $data)  :void;
    public function allByUserId(int $id):Collection;
    public function all()               :Collection;
}