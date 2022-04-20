<?php

namespace App\Http\Services\Abstraction\Availability;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class AvailabilityBuilderServiceInterface
 *
 * @package App\Http\Services\Abstraction\Availability
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
interface AvailabilityBuilderServiceInterface
{
    /**
     * Build method builds availabilities by date period. Response contains pagination of availabilities
     * and in each of them includes pagination of availability dates.
     *
     * @param Collection $availabilities
     * @param $startDateSearch
     * @param $endDateSearch
     *
     * @return array
     */
    public function build(Collection $availabilities, $startDateSearch, $endDateSearch): array;
}