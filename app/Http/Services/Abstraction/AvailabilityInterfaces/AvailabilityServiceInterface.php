<?php
/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 8.4.2022.
 * Time: 22:58
 */

namespace App\Http\Services\Abstraction\AvailabilityInterfaces;


use App\Http\Requests\Availability\AllByDateRangeRequest;
use App\Http\Requests\Availability\StoreRequest;
use Illuminate\Http\Request;

interface AvailabilityServiceInterface
{
    public function store(StoreRequest $request):void;
    public function filterByUserId(int $id): ?iterable;
    public function filterByDateRange(AllByDateRangeRequest $request);
    public function filterByUser(Request $request);
    public function all();


}