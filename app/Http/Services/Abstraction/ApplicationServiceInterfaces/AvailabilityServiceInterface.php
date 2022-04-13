<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 22:58
 */

namespace App\Http\Services\Abstraction\ApplicationServiceInterfaces;


use App\Http\Requests\Availability\AllByDateRangeRequest;
use App\Http\Requests\Availability\AvailabilityStoreRequest;

interface AvailabilityServiceInterface
{
    public function store(AvailabilityStoreRequest $request):void;
    public function allByUserId(int $id): ?iterable;
    public function allByDateRange(AllByDateRangeRequest $request);
    public function all();
}