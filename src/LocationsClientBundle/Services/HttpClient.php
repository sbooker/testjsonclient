<?php

declare(strict_types=1);

namespace LocationsClientBundle\Services;

use LocationsClientBundle\Services\Exceptions\HttpErrorCodeException;
use LocationsClientBundle\Services\Exceptions\HttpTransportException;

interface HttpClient
{
    /**
     * @throws HttpErrorCodeException
     * @throws HttpTransportException
     */
    public function getContent(string $url): string;
}