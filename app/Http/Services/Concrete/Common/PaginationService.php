<?php

namespace App\Http\Services\Concrete\Common;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Class PaginationService
 *
 * @package App\Http\Services\Concrete\Common
 * @author  Nikola Zekavica <nikolazekavica88@yahoo.com>
 */
class PaginationService
{
    /**
     * @var PaginationService
     */
    private static $instance = null;

    /**
     * Get instance of PaginationService
     *
     * @return PaginationService|null
     */
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new PaginationService();
        }
        return self::$instance;
    }

    /**
     * Pagination results
     *
     * @param Collection $collection
     * @param int $perPage
     * @param string $pageName
     *
     * @return array
     */
    public function pagination(Collection $collection, int $perPage = 10, string $pageName = 'page'): array
    {
        $page = LengthAwarePaginator::resolveCurrentPage($pageName);

        $pagination = new LengthAwarePaginator(
            $collection->forPage($page, $perPage),
            $collection->count(),
            $perPage,
            $page,
            [
                'path'     => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        );

        return $this->format($pagination);
    }

    /**
     * Set response format for pagination.
     *
     * @param LengthAwarePaginator $data
     *
     * @return array
     */
    private function format(LengthAwarePaginator $data): array
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