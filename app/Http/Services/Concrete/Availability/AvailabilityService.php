<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 7.4.2022.
 * Time: 10:51
 */
namespace App\Http\Services\Concrete\Availability;

use App\Helpers\Constants;
use App\Http\Requests\Availability\AllByDateRangeRequest;
use App\Http\Repositories\Abstraction\AvailabilityRepositoryInterface;
use App\Http\Requests\Availability\StoreRequest;
use App\Http\Services\Abstraction\Availability\AvailabilityBuilderServiceInterface;
use App\Http\Services\Abstraction\Availability\AvailabilityServiceInterface;
use App\Http\Services\Concrete\Common\DateTimeConverter;
use App\Http\Traits\DateTimeTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AvailabilityService implements AvailabilityServiceInterface
{
    use DateTimeTrait;

    protected $availabilityRepository;
    protected $availabilityBuilderService;

    public function __construct(
        AvailabilityRepositoryInterface $availabilityRepository,
        AvailabilityBuilderServiceInterface $availabilityBuilderService
    ) {
        $this->availabilityRepository     = $availabilityRepository;
        $this->availabilityBuilderService = $availabilityBuilderService;
    }

    public function store(array $request):void
    {
        $request['user_id']    = auth('api')->user()->getAuthIdentifier();
        $request['start_date'] =  Carbon::parse($request['start_date'])->format(Constants::DATE_FORMAT_MYSQL);
        $request['end_date']   =  Carbon::parse($request['end_date'])->format(Constants::DATE_FORMAT_MYSQL);

        $this->availabilityRepository->store($request);
    }

    public function filterByUserId(int $id): ?iterable
    {
        $startDateSearch = $this->startDateLimitSearch()->getTimestamp();
        $endDateSearch   = $this->endDateLimitSearch()->getTimestamp();

        $availabilities  = $this->availabilityRepository->allByUserId($id);

        return $this->availabilityBuilderService->build($availabilities, $startDateSearch, $endDateSearch);
    }

    public function all()
    {
        $startDateSearch = $this->startDateLimitSearch()->getTimestamp();
        $endDateSearch   = $this->endDateLimitSearch()->getTimestamp();

        $availabilities  = $this->availabilityRepository->all();

        return $this->availabilityBuilderService->build($availabilities, $startDateSearch, $endDateSearch);
    }

    public function filterByDateRange(AllByDateRangeRequest $request)
    {
        $startDateSearch = Carbon::make($request->get('start_date'))->getTimestamp();
        $endDateSearch   = Carbon::make($request->get('end_date'))->getTimestamp();

        $availabilities  = $this->availabilityRepository->all();

        return $this->availabilityBuilderService->build($availabilities, $startDateSearch, $endDateSearch);
    }

    public function filterByUser(Request $request)
    {
        $startDateSearch = $this->startDateLimitSearch()->getTimestamp();
        $endDateSearch   = $this->endDateLimitSearch()->getTimestamp();

        $availabilities  = $this->availabilityRepository->filterByUser($request->all());

        return $this->availabilityBuilderService->build($availabilities, $startDateSearch, $endDateSearch);
    }
}