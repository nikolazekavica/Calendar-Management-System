<?php

namespace App\Http\Controllers\Calendar\v1;

use App\Helpers\CalendarResponse;
use App\Http\Requests\Availability\AllByDateRangeRequest;
use App\Http\Requests\Availability\AllByUserRequest;
use App\Http\Requests\Availability\StoreRequest;
use App\Http\Services\Abstraction\Availability\AvailabilityServiceInterface;

use Illuminate\Http\Response;

/**
 * Class AvailabilityController
 *
 * @package App\Http\Controllers\Calendar\v1
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class AvailabilityController extends Controller
{
    /**
     * @var AvailabilityServiceInterface
     */
    private $availabilityService;

    /**
     * AvailabilityController constructor.
     *
     * @param $availabilityService $service
     */
    public function __construct(AvailabilityServiceInterface $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    /**
     * Store availability
     *
     * @param StoreRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $this->availabilityService->store($request->all());

        return CalendarResponse::success(
            "Availability successfully inserted.",
            Response::HTTP_CREATED
        );
    }

    /**
     * Get all availabilities
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $availabilities = $this->availabilityService->all();

        return CalendarResponse::success(
            "Availabilities successfully returned.",
            Response::HTTP_OK,
            $availabilities
        );
    }

    /**
     * Get all availabilities by user id
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function allByUserId(int $id)
    {
        $availabilities = $this->availabilityService->filterByUserId($id);

        return CalendarResponse::success(
            "Availabilities successfully returned.",
            Response::HTTP_OK,
            $availabilities
        );
    }

    /**
     * Get all availabilities by date range
     *
     * @param AllByDateRangeRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function allByDateRange(AllByDateRangeRequest $request)
    {
        $availabilities = $this->availabilityService->filterByDateRange($request);

        return CalendarResponse::success(
            "Availabilities successfully returned.",
            Response::HTTP_OK,
            $availabilities
        );
    }

    /**
     * Get all availabilities by user params
     *
     * @param AllByUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function allByUser(AllByUserRequest $request)
    {
        $availabilities = $this->availabilityService->filterByUser($request);

        return CalendarResponse::success(
            "Availabilities successfully returned.",
            Response::HTTP_OK,
            $availabilities
        );
    }
}