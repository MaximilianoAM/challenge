<?php

namespace App\Responses;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ResourceResponse
 * @package App\Responses
 */
class ResourceResponse extends SuccessResponse
{
    public const RESPONSE_SHOW = 'resource.show';
    public const RESPONSE_UPDATE = 'resource.update';
    public const RESPONSE_DELETE = 'resource.delete';
    public const RESPONSE_STORE = 'resource.store';

    /**
     * Resource constructor.
     * @param JsonResource $resource
     * @param string $responseCode
     */
    public function __construct(JsonResource $resource, string $responseCode)
    {
        parent::__construct($responseCode);
        $this->setData($resource->toArray(request()));
    }
}
