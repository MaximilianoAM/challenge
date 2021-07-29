<?php

namespace App\Http\Requests;

use App\Exceptions\Http\ValidationException;
use Exception;
use Illuminate\Foundation\Http\FormRequest as Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

/**
 * Class FormRequest
 * @package App\Http\Requests
 */
abstract class FormRequest extends Request
{
    /**
     * @var Collection
     */
    protected $rules;

    /**
     * @var Collection
     */
    protected $data;

    /**
     * FormRequest constructor.
     * @param array $query
     * @param array $request
     * @param array $attributes
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param null $content
     */
    public function __construct(
        array $query = array(),
        array $request = array(),
        array $attributes = array(),
        array $cookies = array(),
        array $files = array(),
        array $server = array(),
        $content = null
    )
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->rules = collect();
        $this->data = collect();
    }

    /**
     * @throws ValidationException
     */
    public function validateResolved(): void
    {
        $this->loadRules();
        $this->loadData();

        $validator = Validator::make(
            $this->data->toArray(),
            $this->rules->toArray(),
            $this->messages()
        );

        if ($validator->fails()) {
            throw new ValidationException(
                $validator
            );
        }
    }

    abstract public function loadRules(): void;

    abstract public function loadData(): void;

    /**
     * @param string $index
     * @param array $replacements
     * @return string
     */
    public function getValidationMessage(string $index, array $replacements = []): string
    {
        return Lang::get($index, $replacements);
    }

    /**
     * @param string $name
     * @param int $id
     */
    public function addRouteParameterId(string $name, int $id): void
    {
        $this->data
            ->put($name, $id);
    }

    /**
     * @return Collection
     */
    public function rules(): Collection
    {
        return $this->rules;
    }

    /**
     * @return Collection
     */
    public function data(): Collection
    {
        return $this->data;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getClassFromLastSegment(): string
    {

        $segments = collect($this->segments())->reverse();

        $model = null;
        foreach ($segments as $segment) {
                $model = ModelRouteBindings::get($segment);
                if ($model) {
                    break;
                }
        }

        if (!$model) {
            throw new Exception('Undefined request model!');
        }

        return $model;
    }

    /**
     * @param string $column
     * @param string $validations
     */
    protected function addRule(string $column, string $validations): void
    {
        $this->rules = $this->rules
            ->put($column, $validations);
    }

    /**
     * @param array $fields
     */
    protected function addParameterFields(array $fields): void
    {
        $this->data = $this->data
            ->merge($this->only($fields));
    }

    /**
     * @param array $rules
     */
    protected function addRules(array $rules): void
    {
        $this->rules = $this->rules
            ->merge($rules);
    }

    /**
     * @param array $fields
     */
    protected function addFields(array $fields): void
    {
        $this->data = $this->data
            ->merge(
                collect($this->all())
                    ->only($fields)
                    ->filter(function ($fields) {
                        return $fields;
                    })
            );
    }
}
