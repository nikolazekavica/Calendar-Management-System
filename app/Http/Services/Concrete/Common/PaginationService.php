<?php

namespace App\Http\Services\Concrete\Common;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Created by PhpStorm.
 * User: n.zekavica
 * Date: 13.4.2022.
 * Time: 12:41
 */

class PaginationService
{
    public static function pagination(Collection $collection, $perPage = 10, $pageName = 'page'): array
    {
        $page = LengthAwarePaginator::resolveCurrentPage($pageName);

        $pagination = new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        );

        return PaginationService::format($pagination);
    }

    /**
     * @param LengthAwarePaginator $data
     * @return array
     */
    private static function format(LengthAwarePaginator $data) :array
    {
        return [
            'total_results' => $data->total(),
            'current_page'  => $data->currentPage(),
            'from'          => $data->firstItem(),
            'to'            => $data->lastItem(),
            'per_page'      => $data->perPage(),
            'next_page_url' => $data->nextPageUrl(),
            'prev_page_url' => $data->previousPageUrl(),
            'items'         => array_values($data->items()),
        ];
    }
}