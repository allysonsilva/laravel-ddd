<?php

namespace App\Support\Exceptions;

use Exception;
use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Symfony\Component\Debug\Exception\FlattenException;

abstract class BaseException extends Exception implements Jsonable, JsonSerializable, Arrayable
{
    /**
     * Response headers.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Response status code.
     *
     * @var int
     */
    protected $statusCode;

    /**
     * Response message.
     *
     * @var string
     */
    protected $message;

    /**
     * @var array
     */
    protected $additionalDetail = [];

    /**
     * @param int        $statusCode
     * @param string     $statusText
     * @param string     $message
     * @param \Exception $previous
     * @param array      $headers
     */
    public function __construct(int $statusCode, string $statusText, string $message = '', Exception $previous = null, array $headers = [])
    {
        $this->headers = $headers;
        $this->statusCode = $statusCode;
        $this->message = $message;

        parent::__construct($message, $statusCode, $previous);
    }

    /**
     * Return headers array.
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Get the status.
     *
     * @return int
     */
    public function getStatus(): int
    {
        return (int) $this->statusCode;
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Convert exception to JSON.
     *
     * @param int $options
     *
     * @return array
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }

    /**
     * @param array $additionalDetail
     *
     * @return $this
     *
     * @example
     *      (new ForbiddenException("Message"))
     *      ->setAdditional([
     *          'foo' => 'bar',
     *      ])->toss();
     */
    public function setAdditional(array $additionalDetail): self
    {
        $this->additionalDetail = $additionalDetail;

        return $this;
    }

    public function getAdditional(): array
    {
        return $this->additionalDetail;
    }

    /**
     * Fails with the current exception object.
     *
     * @throws \App\Support\Exceptions\BaseException
     */
    public function toss()
    {
        throw $this;
    }

    /**
     * Return the Exception as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        $data = [];

        $data['status'] = $this->getStatus();
        $data['message'] = $this->getMessage();
        $data['headers'] = $this->getHeaders();
        $data['additional'] = $this->getAdditional();

        if (app()->environment(['local', 'debug']) || ! empty($this->getPrevious()))
            $data['trace'] = FlattenException::create($this->getPrevious())->getTrace();

        return $data;
    }
}
