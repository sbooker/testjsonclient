<?php

declare(strict_types=1);

namespace LocationsClientBundle\Services;

use JMS\Serializer\Exception\Exception as JmsException;
use JMS\Serializer\SerializerInterface;
use LocationsClientBundle\Services\Exceptions\DeserializationException;
use LocationsClientBundle\Services\Exceptions\ErrorResponseException;
use LocationsClientBundle\Services\Exceptions\LocationsClientBundleException;
use LocationsClientBundle\Services\Exceptions\JsonDecodeException;
use LocationsClientBundle\Services\Exceptions\WrongResponseFormatException;

class LocationsClient
{
    const
        SUCCESS = 'success',
        DATA = 'data',
        LOCATIONS = 'locations'
    ;

    /**
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(HttpClient $httpClient, SerializerInterface $serializer)
    {
        $this->httpClient = $httpClient;
        $this->serializer = $serializer;
    }

    /**
     * @return LocationData[]
     * @throws LocationsClientBundleException
     */
    public function getLocations(string $url): iterable
    {
        $content = $this->httpClient->getContent($url);

        $response = $this->parseJson($content);

        $this->checkResponseFormat($response);
        $isSuccess = $response[self::SUCCESS];
        $data = $response[self::DATA];

        if (true === $isSuccess) {
            return $this->processSuccessResponse($data);
        }

        if (false === $isSuccess) {
            $this->processErrorResponse($data);
        }

        throw new WrongResponseFormatException("Field 'success' must be 'true' or 'false'");
    }

    private function parseJson(string $content): array
    {
        $data = json_decode($content, true);

        if (!is_array($data)) {
            $jsonError = json_last_error();
            if (JSON_ERROR_NONE === $jsonError) {
                throw new WrongResponseFormatException("Response must be array. '{$data}' given");
            } else {
                throw new JsonDecodeException(json_last_error_msg(), $jsonError);
            }
        }

        return $data;
    }

    private function checkResponseFormat(array $response): void
    {
        if (!isset($response[self::SUCCESS]) || !isset($response[self::DATA])) {
            throw new WrongResponseFormatException("Response must have 'success' and 'data' fields");
        }
    }

    private function processSuccessResponse(array $data): iterable
    {
        if (!isset($data[self::LOCATIONS])) {
            throw new WrongResponseFormatException("Response must have 'data.locations' field");
        }

        try {
            return
                $this->serializer->deserialize(
                    $data[self::LOCATIONS],
                    'ArrayCollection<\LocationsClientBundle\Services\LocationData>',
                    'json'
                );
        } catch (JmsException $e) {
            throw new DeserializationException("Deserialization error", 0, $e);
        }
    }

    private function processErrorResponse(array $data): void
    {
        try {
            /** @var ErrorData $error */
            $error = $this->serializer->deserialize(json_encode($data), ErrorData::class, 'json');

            throw new ErrorResponseException($error->getMessage(), $error->getCode());
        } catch (JmsException $e) {
            throw new DeserializationException("Deserialization error", 0, $e);
        }
    }
}