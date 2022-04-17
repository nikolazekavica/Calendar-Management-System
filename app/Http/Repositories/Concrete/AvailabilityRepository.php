<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 7.4.2022.
 * Time: 10:53
 */

namespace App\Http\Repositories\Concrete;

use App\Http\Repositories\Abstraction\AvailabilityRepositoryInterface;
use App\Models\Availability;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class AvailabilityRepository implements AvailabilityRepositoryInterface
{
    protected $model;

    public function __construct(Availability $model)
    {
        $this->model = $model;
    }

    public function store(array $data):void
    {
        $this->model->create($data);
    }

    public function allByUserId(int $id):Collection
    {
        $availabilities = $this->model->where('user_id', $id)->get();
        return $availabilities;
    }

    public function all():Collection
    {
        $availabilities = $this->model->with('user')->get();
        return $availabilities;
    }

    public function filterByUser(array $params):Collection
    {
        $query = $this->model->newQuery()->with('user');

        foreach($params as $key => $value){
            $query->whereRelation('user', $key, $value);
        }

        return $query->get();
    }
}