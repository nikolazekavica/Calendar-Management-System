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
    /**
     * @param array $data
     * @return array
     */
    private static function format(array $data)
    {
        return [
            'total_results' => $data['total'],
            'current_page'  => $data['current_page'],
            'from'          => $data['from'],
            'to'            => $data['to'],
            'per_page'      => $data['per_page'],
            'next_page_url' => $data['next_page_url'],
            'prev_page_url' => $data['prev_page_url'],
            'items'         => array_values($data['data']),
        ];
    }

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

        return PaginationService::format($pagination->toArray());
    }
}