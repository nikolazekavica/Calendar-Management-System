<?php

namespace App\Http\Repositories\Abstraction;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class AvailabilityRepositoryInterface
 *
 * @package App\Http\Repositories\Abstraction
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
interface AvailabilityRepositoryInterface
{
    /**
     * Store availability.
     *
     * @param array $data
     */
    public function store(array $data): void;

    /**
     * Get availabilities by user id.
     *
     * @param int $id
     *
     * @return Collection
     */
    public function allByUserId(int $id): Collection;

    /**
     * Get all availabilities.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Get all by user params.
     *
     * @param array $userParams
     *
     * @return Collection
     */
    public function filterByUser(array $userParams): Collection;
}