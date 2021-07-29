<?php

namespace App\Helpers\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Model;

/**
 * Trait Searchable
 * @package App\Helpers\Models
 */
trait Searchable
{
    /**
     * @param Builder $builder
     * @param null|string $subject
     * @return Builder
     */
    public function scopeSearch(Builder $builder, ?string $subject) : Builder
    {
        if (!empty($subject)) {
            $builder = $builder->where(function (Builder $builder) use ($subject) {
                $this->addColumnsSearch($builder, $subject);
            });
        }

        return $builder;
    }

    /**
     * @param Builder $builder
     * @param string $subject
     */
    private function addColumnsSearch(Builder &$builder, string $subject)
    {
        if ($columns = $builder->getModel()->useColumnsToSearch()) {
            $builder->where(function (Builder $builder) use ($subject, $columns) {
                foreach ($columns as $key => $column) {
                    $builder->orWhereRaw("LOWER(CAST($column as CHAR(1000))) LIKE LOWER('$subject%')");
                }
            });
        }
    }

    /**
     * Defines the model's columns that will be used to search
     * @return array
     */
    abstract public function useColumnsToSearch() : array;
}
