<?php

namespace App\Responses;

use App\Facades\Resources\FailureResponses;
use App\Facades\Resources\SuccessResponses;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JsonSerializable;

/**
 * Class Response
 * @package App\Responses
 */
abstract class Response implements Responsable, JsonSerializable
{
    public const SUCCESS = true;
    public const FAILURE = false;

    /**
     * @var bool
     */
    protected $isDebugEnable;

    /**
     * @var array
     */
    protected $schema;

    /**
     * @var bool
     */
    private $success;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $code;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var array
     */
    private $headers;

    /**
     * Schema constructor.
     * @param bool $success
     * @param string $responseCode
     */
    public function __construct(bool $success, string $responseCode)
    {
        $this->isDebugEnable = config('app.debug');
        $this->success = $success;
        $this->headers = [];

        $response = $this->getResponseData($responseCode);
        $this->setMessage($response['message']);
        $this->setStatusCode($response['statusCode']);
        $this->setCode($response['code']);
    }

    /**
     * @param string $responseCode
     * @return array
     */
    private function getResponseData(string $responseCode): array
    {
        if ($this instanceof SuccessResponse) {
            $response = SuccessResponses::get($responseCode);
        } else {
            $response = FailureResponses::get($responseCode);
        }

        return $response;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function toResponse($request)
    {
        $this->defineSchema();

        return response()
            ->json(
                $this->jsonSerialize(),
                $this->statusCode,
                $this->headers
            );
    }

    private function defineSchema(): void
    {
        $this->schema = [
            'success' => $this->success,
            'message' => $this->message,
            'code' => $this->code,
            'statusCode' => $this->statusCode,
        ];
    }
}
