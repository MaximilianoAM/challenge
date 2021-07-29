<?php

namespace App\Responses;

use App\Helpers\Models\PaginatedResult;

/**
 * Class ResourceCollectionResponse
 * @package App\Responses
 */
class ResourceCollectionResponse extends SuccessResponse
{
    /**
     * @var array
     */
    private array $paginationInfo;

    /**
     * @const string
     */
    public const RESPONSE_CODE = 'resource.index';

    /**
     * ResourceCollection constructor.
     * @param PaginatedResult $result
     */
    public function __construct(PaginatedResult $result)
    {
        parent::__construct(self::RESPONSE_CODE);

        $this->setData($result->getData());
        $this->paginationInfo = $result->getPaginatorInfo();
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        $schema = parent::jsonSerialize();
        $schema['resultsInfo'] = $this->paginationInfo;
        return $schema;
    }
}
