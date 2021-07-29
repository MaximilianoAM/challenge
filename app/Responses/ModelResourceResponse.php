<?php

namespace App\Responses;

use App\Http\Resources\ModelResource;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ModelResourceResponse
 * @package App\Responses
 */
class ModelResourceResponse extends ResourceResponse
{
    /**
     * ModelResourceResponse constructor.
     * @param Model $model
     * @param string $responseCode
     */
    public function __construct(Model $model, string $responseCode)
    {
        parent::__construct(
            ModelResource::make($model),
            $responseCode
        );
    }
}
