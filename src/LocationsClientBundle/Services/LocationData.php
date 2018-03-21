<?php

declare(strict_types=1);

namespace LocationsClientBundle\Services;

use JMS\Serializer\Annotation as Serializer;

class LocationData
{
    /**
     * @Serializer\Type("string")
     * @var string
     */
    private $name;

    /**
     * @Serializer\Type("LocationsClientBundle\Services\CoordinatesData")
     * @var CoordinatesData
     */
    private $coordinates;

    public function __construct(string $name, CoordinatesData $coordinates)
    {
        $this->name = $name;
        $this->coordinates = $coordinates;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCoordinates(): CoordinatesData
    {
        return $this->coordinates;
    }
}