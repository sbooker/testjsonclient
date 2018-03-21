<?php

declare(strict_types=1);

namespace LocationsClientBundle\Services;

use JMS\Serializer\Annotation as Serializer;

class CoordinatesData
{
    /**
     * @Serializer\Type("string")
     * @var string
     */
    private $latitude;

    /**
     * @Serializer\Type("string")
     * @var string
     */
    private $longitude;

    public function __construct(string $latitude, string $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude(): string
    {
        return $this->latitude;
    }

    public function getLongitude(): string
    {
        return $this->longitude;
    }
}