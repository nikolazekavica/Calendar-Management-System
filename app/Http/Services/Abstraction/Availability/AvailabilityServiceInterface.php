<?php

namespace App\Http\Services\Abstraction\Availability;

use App\Http\Requests\Availability\AllByDateRangeRequest;
use Illuminate\Http\Request;

/**
 * Class AvailabilityServiceInterface
 *
 * @package App\Http\Services\Abstraction\Availability
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
interface AvailabilityServiceInterface
{
    /**
     * Store availability. Before store data, method convert dates to mysql date format.
     *
     * @param array $request
     */
    public function store(array $request): void;

    /**
     * Filter availability by user id.
     *
     * @param int $id
     *
     * @return array
     */
    public function filterByUserId(int $id): array;

    /**
     * Get all availabilities.
     *
     * @return array
     */
    public function all(): array;

    /**
     * Filter availabilities by date range.
     *
     * @param AllByDateRangeRequest $request
     *
     * @return array
     */
    public function filterByDateRange(AllByDateRangeRequest $request): array;

    /**
     * Filter availabilities by user params.
     *
     * @param Request $request
     *
     * @return array
     */
    public function filterByUser(Request $request): array;
}