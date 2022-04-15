<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 12.4.2022.
 * Time: 12:00
 */

namespace App\Http\Traits;


use Carbon\Carbon;

trait DateTimeTrait
{
    public function dateTimeNow():Carbon
    {
        return Carbon::now()->setTimezone(config('app.timezone'));
    }

    public function endDateLimitSearch():Carbon
    {
        return $this->dateTimeNow()->addYears(3);
    }

    public function startDateLimitSearch():Carbon
    {
        return $this->dateTimeNow()->subYears(3);
    }
}