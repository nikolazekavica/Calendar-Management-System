<?php

namespace App\Http\Services\Abstraction\CommonServiceInterfaces;

use Illuminate\Database\Eloquent\Collection;

/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 13.4.2022.
 * Time: 16:31
 */

interface AvailabilityBuilderServiceInterface
{
    public function build(Collection $availabilities, $startDateSearch, $endDateSearch):array;
}