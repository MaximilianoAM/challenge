<?php

namespace App\Helpers\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

/**
 * Trait Filterable
 * @package App\Helpers\Models
 */
trait Filterable
{
    /**
     * @param Builder $builder
     * @param array|null $filters
     * @return Builder
     */
    public function scopeFilter(Builder $builder, ?array $filters): Builder
    {
        if (!empty($filters)) {
            $this->applyFilters($builder, $filters);
        }
        return $builder;
    }

    /**
     * @param Builder $queryBuilder
     * @param array $filters
     */
    private function applyFilters(Builder $queryBuilder, array $filters)
    {
        foreach ($filters as $column => $value) {
            if (!Schema::hasColumns(
                $queryBuilder->getModel()->getTable(),
                [$column])
            ) {
                continue;
            }

            if (is_array($value)) {
                $queryBuilder->whereIn($column, $value);
            } else {
                $queryBuilder->where($column, '=', $value);
            }
        }
    }
}
