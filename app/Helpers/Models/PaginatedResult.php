<?php

namespace App\Helpers\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class PaginatedResult
 * @package App\Helpers\Models
 */
class PaginatedResult
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var LengthAwarePaginator
     */
    private $paginator;

    /**
     * PaginatedResult constructor.
     * @param array $data
     * @param LengthAwarePaginator $paginator
     */
    public function __construct(array $data, LengthAwarePaginator $paginator)
    {
        $this->data = $data;
        $this->paginator = $paginator;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getPaginatorInfo(): array
    {
        return [
            'currentPage' => $this->paginator->currentPage(),
            'from' => $this->paginator->firstItem(),
            'lastPage' => $this->paginator->lastPage(),
            'nextPageUrl' => $this->paginator->nextPageUrl(),
            'perPage' => $this->paginator->perPage(),
            'prevPageUrl' => $this->paginator->previousPageUrl(),
            'to' => $this->paginator->lastItem(),
            'total' => $this->paginator->total(),
        ];
    }
}
