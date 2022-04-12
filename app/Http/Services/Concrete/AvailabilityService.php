<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 7.4.2022.
 * Time: 10:51
 */
namespace App\Http\Services\Concrete;

use App\Helpers\Constants;
use App\Http\Requests\Availability\AllByDateRangeRequest;
use App\Http\Repositories\Abstraction\AvailabilityRepositoryInterface;
use App\Http\Requests\Availability\AvailabilityStoreRequest;
use App\Http\Services\Abstraction\AvailabilityServiceInterface;
use App\Http\Traits\DateTimeTrait;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection;

class AvailabilityService implements AvailabilityServiceInterface
{
    use DateTimeTrait;

    protected $availabilityRepository;

    public function __construct(AvailabilityRepositoryInterface $availabilityRepository)
    {
        $this->availabilityRepository = $availabilityRepository;
    }

    public function store(AvailabilityStoreRequest $request):void
    {
        $this->availabilityRepository->store($request->all());
    }

    public function allByUserId(int $id): ?iterable
    {
        $startDateSearch = $this->startDateLimitSearch()->getTimestamp();
        $endDateSearch   = $this->endDateLimitSearch()->getTimestamp();

        $availabilities          = $this->availabilityRepository->allByUserId($id);
        $availabilityProjections = $this->availabilityBuilder($availabilities, $startDateSearch, $endDateSearch);

        return $availabilityProjections;
    }

    public function all()
    {
        $startDateSearch = $this->startDateLimitSearch()->getTimestamp();
        $endDateSearch   = $this->endDateLimitSearch()->getTimestamp();

        $availabilities  = $this->availabilityRepository->all();

        return $this->availabilityBuilder($availabilities, $startDateSearch, $endDateSearch);
    }

    public function allByDateRange(AllByDateRangeRequest $request)
    {
        $startDateSearch = Carbon::make($request->get('start_date'))->getTimestamp();
        $endDateSearch   = Carbon::make($request->get('end_date'))->getTimestamp();

        $availabilities          = $this->availabilityRepository->all();
        $availabilityProjections = $this->availabilityBuilder($availabilities, $startDateSearch, $endDateSearch);

        return $availabilityProjections;
    }

    private function availabilityBuilder(Collection $availabilities, $startDateSearch, $endDateSearch) :Collection
    {
        $availabilityProjections = new Collection();

        foreach($availabilities as $availability) {

            $availabilityPeriod = CarbonPeriod::create(
                $availability['start_date'],
                $availability['end_date']
            )->toArray();

            $period = new Collection();

            foreach ($availabilityPeriod as $availabilityDate) {

                $date                 = $availabilityDate->format(Constants::DATE_FORMAT_PROJECT);
                $dateWithTime         = $date.' '.$availability['start_time'];
                $availabilityDateTime = Carbon::parse($dateWithTime)->getTimestamp();

                if($availabilityDateTime     >= $startDateSearch
                    && $availabilityDateTime <= $endDateSearch
                ) {
                    $period->push($availabilityDate->format(Constants::DATE_FORMAT_PROJECT));
                }

                if($availability['is_recurrences'] == 1) {

                    $periodRecurring = CarbonPeriod::create(
                        $availability['start_date_recurrences'],
                        $availability['end_date_recurrences']
                    )->toArray();

                    foreach ($periodRecurring as $recurringDate){
                        if($availabilityDate->format('l') == $recurringDate->format('l')
                            && $recurringDate->getTimestamp() >= $startDateSearch
                            && $recurringDate->getTimestamp() <= $endDateSearch
                        ){
                            $period->push($recurringDate->format(Constants::DATE_FORMAT_PROJECT));
                        }
                    }
                }
            }

            if($period->isEmpty()) {
                continue;
            }

            $availability->setAttribute('period', $period);

            $availability->makeHidden(
                    'start_date',
                    'end_date',
                    'start_date_recurrences',
                    'end_date_recurrences',
                    'is_recurrences',
                    'user_id'
            );

            $availabilityProjections->push($availability);
        }

        return $availabilityProjections;
    }
}