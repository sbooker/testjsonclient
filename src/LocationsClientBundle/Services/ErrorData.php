<?php

declare(strict_types=1);

namespace LocationsClientBundle\Services;

use JMS\Serializer\Annotation as Serializer;

class ErrorData
{
    /**
     * @Serializer\Type("string")
     * @var string
     */
    private $code;

    /**
     * @Serializer\Type("string")
     * @var string
     */
    private $message;

    public function __construct(string $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}