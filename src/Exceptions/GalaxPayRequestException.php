<?php

namespace JosanBr\GalaxPay\Exceptions;

/**
 * @property string $message
 * @property int $status
 * @property array $details
 */
class GalaxPayRequestException extends \Exception implements \JsonSerializable
{
    /**
     * Error message
     * @var string
     */
    protected $message;

    /**
     * HTTP Status Code
     * @var int
     */
    protected $status;

    /**
     * Details about the error, showing which field and which error
     * - Array whose key is Entity.field where the error occurred and each value is a description of the problem.
     * @var array
     */
    protected $details;

    /**
     *
     * @param int    $code
     * @param string $message
     * @param array   $previous
     */
    public function __construct(string $message, int $status, array $details = [])
    {
        parent::__construct($message, $status);

        $this->status = $status;
        $this->message = $message;
        $this->details = $details;
    }

    public function __get($property)
    {
        return property_exists($this, $property) ? $this->$property : null;
    }

    public function jsonSerialize(): array
    {
        return ['message' => $this->message, 'details' => $this->details, 'status' => $this->status];
    }
}
