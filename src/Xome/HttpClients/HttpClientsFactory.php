<?php
namespace Xome\HttpClients;

use Exception;
use GuzzleHttp\Client;
use InvalidArgumentException;

class HttpClientsFactory
{
    private function __construct()
    {
        // a factory constructor should never be invoked
    }

    /**
     * HTTP client generation.
     *
     * @param XomeHttpClientInterface|Client|string|null $handler
     *
     * @throws Exception                If the cURL extension or the Guzzle client aren't available (if required).
     * @throws InvalidArgumentException If the http client handler isn't "curl", "stream", "guzzle", or an instance of Xome\HttpClients\XomeHttpClientInterface.
     *
     * @return XomeHttpClientInterface
     */
    public static function createHttpClient($handler)
    {
        if (!$handler) {
            return self::detectDefaultClient();
        }
        if ($handler instanceof XomeHttpClientInterface) {
            return $handler;
        }

        if ('stream' === $handler) {
            return new XomeStreamHttpClient();
        }

        if ('guzzle' === $handler && !class_exists('GuzzleHttp\Client')) {
            throw new Exception('The Guzzle HTTP client must be included in order to use the "guzzle" handler.');
        }
        if ($handler instanceof Client) {
            return new XomeGuzzleHttpClient($handler);
        }
        if ('guzzle' === $handler) {
            return new XomeGuzzleHttpClient();
        }
        throw new InvalidArgumentException('The http client handler must be set to "curl", "stream", "guzzle", be an instance of GuzzleHttp\Client or an instance of Xome\HttpClients\XomeHttpClientInterface');
    }

    /**
     * Detect default HTTP client.
     *
     * @return XomeHttpClientInterface
     */
    private static function detectDefaultClient()
    {
        if (class_exists('GuzzleHttp\Client')) {
            return new XomeGuzzleHttpClient();
        }
        return new XomeStreamHttpClient();
    }
}
