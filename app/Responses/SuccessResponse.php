<?php

namespace App\Responses;

/**
 * Class SuccessResponse
 * @package App\Responses
 */
class SuccessResponse extends Response
{
    private $data;

    /**
     * Success constructor.
     * @param string $responseCode
     * @param array $data
     */
    public function __construct(string $responseCode, array $data = [])
    {
        parent::__construct(Response::SUCCESS, $responseCode);
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getData() : array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function jsonSerialize() : array
    {
        $this->schema['data'] = $this->data;
        return $this->schema;
    }
}
