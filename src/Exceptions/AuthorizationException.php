<?php

namespace JosanBr\GalaxPay\Exceptions;

class AuthorizationException extends \Exception implements \JsonSerializable
{
    /** @var int */
    private $status;

    public function __construct($status, $message)
    {
        parent::__construct($message, $status);

        $this->status = $status;
    }

    public function __toString()
    {
        return 'Authorization Error ' . $this->status . ': ' . $this->message . PHP_EOL;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function jsonSerialize(): array
    {
        return ['message' => $this->message, 'status' => $this->status];
    }
}
