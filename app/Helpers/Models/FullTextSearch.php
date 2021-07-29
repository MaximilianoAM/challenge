<?php

namespace App\Helpers\Models;

use App\Exceptions\Http\UnexpectedException;
use App\Http\Requests\ListingModelRequest;
use App\Http\Resources\ModelResource;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Model;

/**
 * Trait FullTextSearch
 * @package App\Helpers\Models
 * @method static PaginatedResult fullTextSearch(ListingModelRequest $request, $scope = null, string $resourceClass = null)
 */
trait FullTextSearch
{
    use Searchable, Filterable;

    /**
     * @param Builder $builder
     * @param ListingModelRequest $request
     * @return PaginatedResult
     * @throws UnexpectedException
     */
    public function scopeFullTextSearch(
        Builder $builder,
        ListingModelRequest $request
    ): PaginatedResult {
        try {
            $model = $builder->getModel();
            $data = $request->all();

            $builder->search(
                $data['q'] ?? null
            );

            $builder->filter(
                $data['filters'] ?? null
            );

            $this->applyOrderBy(
                $builder,
                $data['orderBy'] ?? '',
                $model
            );

            $listing = $builder->paginate(
                $data['limit'] ?? 15,
                [$model->getTable() . ".*"],
                'page',
                $data['page'] ?? 1
            );

            $collection = array_values(array_filter($this->getResource()::collection($listing)->toArray($request)));

            return new PaginatedResult($collection, $listing);
        } catch (Exception $e) {
            throw new UnexpectedException($e);
        }
    }

    /**
     * @param Builder $builder
     * @param string $orderBy
     * @param Model $model
     */
    private function applyOrderBy(Builder $builder, string $orderBy, Model $model)
    {
        if (empty($orderBy)) {
            [$by, $order] = [$model->timestamps ? $model->getUpdatedAtColumn() : 'id', 'desc'];
        } else {
            [$by, $order] = explode(',', $orderBy);
        }

        $builder->orderBy($by, $order);
    }

    /**
     * @return JsonResource
     */
    public function getResource(): JsonResource
    {
        return new ModelResource(self::class);
    }
}
