<?php

namespace App\Http\Repositories\Concrete;

use App\Http\Repositories\Abstraction\AvailabilityRepositoryInterface;
use App\Models\Availability;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class AvailabilityRepository
 *
 * @package App\Http\Repositories\Concret
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class AvailabilityRepository implements AvailabilityRepositoryInterface
{
    /**
     * @var Availability
     */
    protected $model;

    /**
     * AvailabilityRepository constructor.
     *
     * @param Availability $model
     */
    public function __construct(Availability $model)
    {
        $this->model = $model;
    }

    /**
     * Store availability.
     *
     * @param array $data
     */
    public function store(array $data): void
    {
        $this->model->create($data);
    }

    /**
     * Get availabilities by user id.
     *
     * @param int $id
     *
     * @return Collection
     */
    public function allByUserId(int $id): Collection
    {
        $availabilities = $this->model->where('user_id', $id)->get();
        return $availabilities;
    }

    /**
     * Get all availabilities.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        $availabilities = $this->model->with('user')->get();
        return $availabilities;
    }

    /**
     * Get all by user params.
     *
     * @param array $userParams
     *
     * @return Collection
     */
    public function filterByUser(array $userParams): Collection
    {
        $query = $this->model->newQuery()->with('user');

        foreach ($userParams as $key => $value) {
            $query->whereRelation('user', $key, $value);
        }

        return $query->get();
    }
}