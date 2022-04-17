<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 6.4.2022.
 * Time: 21:20
 */
namespace App\Http\Controllers\Calendar\v1;

use App\Helpers\CalendarResponse;
use App\Http\Requests\Availability\AllByDateRangeRequest;
use App\Http\Requests\Availability\AllByUserRequest;
use App\Http\Requests\Availability\StoreRequest;
use App\Http\Services\Abstraction\AvailabilityInterfaces\AvailabilityServiceInterface;
use Illuminate\Http\Response;

class AvailabilityController extends Controller
{
    private $availabilityService;

    public function __construct(AvailabilityServiceInterface $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    public function store(StoreRequest $request)
    {
        $this->availabilityService->store($request);
        return CalendarResponse::success(
            "Availability successfully inserted.",
            Response::HTTP_CREATED
        );
    }

    public function all()
    {
        $availabilities = $this->availabilityService->all();
        return CalendarResponse::success(
            "Availabilities successfully returned.",
            Response::HTTP_CREATED,
            $availabilities
        );
    }

    public function allByUserId(int $id)
    {
        $availabilities = $this->availabilityService->filterByUserId($id);
        return CalendarResponse::success(
            "Availabilities successfully returned.",
            Response::HTTP_CREATED,
            $availabilities
        );
    }

    public function allByDateRange(AllByDateRangeRequest $request)
    {
        $availabilities = $this->availabilityService->filterByDateRange($request);

        return CalendarResponse::success(
            "Availabilities successfully returned.",
            Response::HTTP_CREATED,
            $availabilities
        );
    }

    public function allByUser(AllByUserRequest $request)
    {
        $availabilities = $this->availabilityService->filterByUser($request);

        return CalendarResponse::success(
            "Availabilities successfully returned.",
            Response::HTTP_CREATED,
            $availabilities
        );
    }
}