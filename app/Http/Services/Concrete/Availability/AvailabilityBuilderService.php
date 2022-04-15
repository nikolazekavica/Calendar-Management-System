<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 13.4.2022.
 * Time: 0:23
 */

namespace App\Http\Services\Concrete\Availability;

use App\Helpers\Constants;
use App\Http\Services\Abstraction\AvailabilityInterfaces\AvailabilityBuilderServiceInterface;
use App\Http\Services\Concrete\Common\PaginationService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Collection;

class AvailabilityBuilderService implements AvailabilityBuilderServiceInterface
{
    public function build(Collection $availabilities, $startDateSearch, $endDateSearch):array
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

            $availability->setAttribute(
                'period',
                PaginationService::pagination(
                    $period,
                    10,
                    'period_'.$availability['id'].'_page'
                )
            );

            $availabilityProjections->push($availability);
        }

        return PaginationService::pagination($availabilityProjections);
    }
}