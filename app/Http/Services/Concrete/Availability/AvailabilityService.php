<?php

namespace App\Http\Services\Concrete\Availability;

use App\Helpers\Constants;
use App\Http\Requests\Availability\AllByDateRangeRequest;
use App\Http\Repositories\Abstraction\AvailabilityRepositoryInterface;
use App\Http\Services\Abstraction\Availability\AvailabilityBuilderServiceInterface;
use App\Http\Services\Abstraction\Availability\AvailabilityServiceInterface;
use App\Http\Traits\DateTimeTrait;

use Carbon\Carbon;

use Illuminate\Http\Request;

/**
 * Class AvailabilityService
 *
 * @package App\Http\Services\Concrete\Availability
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class AvailabilityService implements AvailabilityServiceInterface
{
    /**
     * DateTimeTrait
     */
    use DateTimeTrait;

    /**
     * @var AvailabilityRepositoryInterface
     */
    protected $availabilityRepository;

    /**
     * @var AvailabilityBuilderServiceInterface
     */
    protected $availabilityBuilderService;

    /**
     * AvailabilityService constructor.
     *
     * @param AvailabilityRepositoryInterface $availabilityRepository
     * @param AvailabilityBuilderServiceInterface $availabilityBuilderService
     */
    public function __construct(
        AvailabilityRepositoryInterface $availabilityRepository,
        AvailabilityBuilderServiceInterface $availabilityBuilderService
    ) {
        $this->availabilityRepository = $availabilityRepository;
        $this->availabilityBuilderService = $availabilityBuilderService;
    }

    /**
     * Store availability. Before store data, method convert dates to mysql date format.
     *
     * @param array $request
     */
    public function store(array $request): void
    {
        $request['user_id']    = auth('api')->user()->getAuthIdentifier();
        $request['start_date'] = Carbon::parse($request['start_date'])->format(Constants::DATE_FORMAT_MYSQL);
        $request['end_date']   = Carbon::parse($request['end_date'])->format(Constants::DATE_FORMAT_MYSQL);

        $this->availabilityRepository->store($request);
    }

    /**
     * Filter availability by user id.
     *
     * @param int $id
     *
     * @return array
     */
    public function filterByUserId(int $id): array
    {
        $availabilities = $this->availabilityRepository->allByUserId($id);

        return $this->availabilityBuilderService->build(
            $availabilities,
            $this->startDateLimitSearch()->getTimestamp(),
            $this->endDateLimitSearch()->getTimestamp()
        );
    }

    /**
     * Get all availabilities.
     *
     * @return array
     */
    public function all(): array
    {
        $availabilities = $this->availabilityRepository->all();

        return $this->availabilityBuilderService->build(
            $availabilities,
            $this->startDateLimitSearch()->getTimestamp(),
            $this->endDateLimitSearch()->getTimestamp()
        );
    }

    /**
     * Filter availabilities by date range.
     *
     * @param AllByDateRangeRequest $request
     *
     * @return array
     */
    public function filterByDateRange(AllByDateRangeRequest $request): array
    {
        $startDateSearch = Carbon::make($request->get('start_date'))->getTimestamp();
        $endDateSearch   = Carbon::make($request->get('end_date'))->getTimestamp();

        $availabilities  = $this->availabilityRepository->all();

        return $this->availabilityBuilderService->build($availabilities, $startDateSearch, $endDateSearch);
    }

    /**
     * Filter availabilities by user params.
     *
     * @param Request $request
     *
     * @return array
     */
    public function filterByUser(Request $request): array
    {
        $availabilities = $this->availabilityRepository->filterByUser($request->all());

        return $this->availabilityBuilderService->build(
            $availabilities,
            $this->startDateLimitSearch()->getTimestamp(),
            $this->endDateLimitSearch()->getTimestamp()
        );
    }
}