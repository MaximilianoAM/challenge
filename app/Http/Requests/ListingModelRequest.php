<?php

namespace App\Http\Requests;

/**
 * Class ListingModelRequest
 * @package App\Http\Requests
 */
class ListingModelRequest extends FormRequest
{
    public function loadData(): void
    {
        $this->addParameterFields([
            'q',
            'filters',
            'limit',
            'orderBy',
            'page',
        ]);
    }

    public function loadRules(): void
    {
        $this->addRule('q', 'bail|nullable|string');
        $this->addRule('filters', 'bail|nullable|array');
        $this->addRule('limit', 'bail|nullable|integer|min:1');
        $this->addRule('orderBy', 'bail|nullable|string');
        $this->addRule('page', 'bail|nullable|integer|min:1');
    }
}
