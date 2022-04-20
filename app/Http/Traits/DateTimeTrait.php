<?php

namespace App\Http\Traits;

use App\Helpers\Constants;
use Carbon\Carbon;

/**
 * Class DateTimeTrait
 *
 * @package App\Http\Traits
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
trait DateTimeTrait
{
    /**
     * Date time now
     *
     * @return Carbon
     */
    public function dateTimeNow(): Carbon
    {
        return Carbon::now()->setTimezone(config('app.timezone'));
    }

    /**
     * Start date limit for search
     *
     * @return Carbon
     */
    public function startDateLimitSearch(): Carbon
    {
        return $this->dateTimeNow()->subYears(Constants::START_DATE_LIMIT_SEARCH);
    }

    /**
     * End date limit for search
     *
     * @return Carbon
     */
    public function endDateLimitSearch(): Carbon
    {
        return $this->dateTimeNow()->addYears(Constants::END_DATE_LIMIT_SEARCH);
    }
}