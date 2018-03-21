<?php

declare(strict_types=1);

namespace LocationsClientBundle\Services;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use LocationsClientBundle\Services\Exceptions\HttpErrorCodeException;
use LocationsClientBundle\Services\Exceptions\HttpTransportException;

class GuzzleWrapper implements HttpClient
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @var array
     */
    private $options;

    public function __construct(ClientInterface $client, array $options = [])
    {
        $this->client = $client;
        $this->options = $options;
    }

    /**
     * @throws HttpErrorCodeException
     * @throws HttpTransportException
     */
    public function getContent(string $url): string
    {
        try {
            $response = $this->client->request('GET', $url, $this->options);

            if ($response->getStatusCode() !== 200) {
                throw new HttpErrorCodeException('Http Error', $response->getStatusCode());
            }

            return $response->getBody()->getContents();
        } catch (GuzzleException $e) {
            throw new HttpTransportException('Http Client Exception', 0, $e);
        }
    }
}