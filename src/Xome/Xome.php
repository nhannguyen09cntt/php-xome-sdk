<?php
namespace Xome;

use Xome\HttpClients\HttpClientsFactory;
use GuzzleHttp\Client;

class Xome
{
    /**
     * @const string Version number of the Xome PHP SDK.
     */
    const VERSION = '1.0';

    const API_KEY_ENV_NAME = 'XOME_API_KEY';

    const API_USER_ENV_NAME = 'XOME_API_USER';

    /**
     * @var AccessToken|null The default access token to use with requests.
     */
    protected $defaultAccessToken;

    protected $client;

    protected $lastResponse;

    public function __construct(array $config = [])
    {
        $config = array_merge([
            // Base URI is used with relative requests
            'base_uri' => 'https://xome.vn',
            // You can set any number of default request options.
            'timeout' => 2.0,
            // Xome Authenticator
            'headers' => [
                'Api-Key' => getenv(static::API_KEY_ENV_NAME),
                'Api-Username' => getenv(static::API_USER_ENV_NAME),
            ],
        ], $config);

        $this->client = new XomeClient(
            HttpClientsFactory::createHttpClient(new Client($config))
        );

        if (isset($config['default_access_token'])) {
            $this->setDefaultAccessToken($config['default_access_token']);
        }
    }

    public function setDefaultAccessToken($accessToken)
    {
        if (is_string($accessToken)) {
            $this->defaultAccessToken = $accessToken;
            return;
        }
    }

    public function request($method, $endpoint, array $params = [], $accessToken = null)
    {
        return new XomeRequest(
            $accessToken,
            $method,
            $endpoint,
            $params
        );
    }

    public function get($endpoint, array $params = [])
    {
        return $this->sendRequest(
            'GET',
            $endpoint,
            $params
        );
    }

    public function post($endpoint, array $params = [])
    {
        return $this->sendRequest(
            'POST',
            $endpoint,
            $params
        );
    }

    public function put($endpoint, array $params = [])
    {
        return $this->sendRequest(
            'PUT',
            $endpoint,
            $params
        );
    }

    public function delete($endpoint, array $params = [])
    {
        return $this->sendRequest(
            'DELETE',
            $endpoint,
            $params
        );
    }

    public function sendRequest($method, $endpoint, array $params = [], $accessToken = null)
    {
        $accessToken = $accessToken ?: $this->defaultAccessToken;
        $request = $this->request($method, $endpoint, $params, $accessToken);

        return $this->lastResponse = $this->client->sendRequest($request);
    }

}
