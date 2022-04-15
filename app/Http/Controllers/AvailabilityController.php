<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 6.4.2022.
 * Time: 21:20
 */
namespace App\Http\Controllers;

use App\Helpers\CalendarResponse;
use App\Http\Requests\Availability\AllByDateRangeRequest;
use App\Http\Requests\Availability\AvailabilityStoreRequest;
use App\Http\Services\Abstraction\AvailabilityInterfaces\AvailabilityServiceInterface;
use Illuminate\Http\Response;

class AvailabilityController extends Controller
{
    private $availabilityService;

    public function __construct(AvailabilityServiceInterface $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    public function store(AvailabilityStoreRequest $request)
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
        $availabilities = $this->availabilityService->allByUserId($id);
        return CalendarResponse::success(
            "Availabilities successfully returned.",
            Response::HTTP_CREATED,
            $availabilities
        );
    }

    public function allByDateRange(AllByDateRangeRequest $request)
    {
        $availabilities = $this->availabilityService->allByDateRange($request);
        return CalendarResponse::success(
            "Availabilities successfully returned.",
            Response::HTTP_CREATED,
            $availabilities
        );
    }
}