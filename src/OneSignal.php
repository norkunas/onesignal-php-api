<?php

namespace OneSignal;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Message\Response;
use OneSignal\Exception\OneSignalException;

/**
 * @property-read Apps          $apps          Applications API service.
 * @property-read Devices       $devices       Devices API service.
 * @property-read Notifications $notifications Notifications API service.
 */
class OneSignal
{
    const API_URL = 'https://onesignal.com/api/v1';

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $services = [];

    /**
     * Constructor.
     *
     * @param Config $config
     * @param Client $client
     */
    public function __construct(Config $config = null, Client $client = null)
    {
        $this->config = ($config ?: new Config());
        $this->client = ($client ?: new Client([
            'defaults' => [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ],
        ]));
    }

    /**
     * Set config.
     *
     * @param Config $config
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Get config.
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Set client.
     *
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get client.
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Make a custom api request.
     *
     * @param string $method  HTTP Method
     * @param string $uri     URI template
     * @param array  $options Array of request options to apply.
     *
     * @throws OneSignalException
     *
     * @return Response
     */
    public function request($method, $uri, array $options = [])
    {
        try {
            $request = $this->client->createRequest($method, self::API_URL . $uri, $options);

            return $this->client->send($request)->json();
        } catch (RequestException $e) {
            $response = $e->getResponse();

            if ($response) {
                $headers = $response->getHeaders();

                if (!empty($headers['Content-Type']) && false !== strpos($headers['Content-Type'][0], 'application/json')) {
                    $body = $response->json();
                    $errors = (isset($body['errors']) ? $body['errors'] : []);

                    if (404 === $response->getStatusCode()) {
                        $errors[] = 'Not Found';
                    }

                    throw new OneSignalException($response->getStatusCode(), $errors, $e->getMessage(), $e->getCode(), $e);
                }
            }

            throw $e;
        }
    }

    /**
     * Create required services on the fly.
     *
     * @param string $name
     *
     * @return object
     */
    public function __get($name)
    {
        if (in_array($name, ['apps', 'devices', 'notifications'], true)) {
            if (isset($this->services[$name])) {
                return $this->services[$name];
            }

            $serviceName = __NAMESPACE__ . '\\' . ucfirst($name);

            $this->services[$name] = new $serviceName($this);

            return $this->services[$name];
        }

        $trace = debug_backtrace();

        $error = 'Undefined property via __get(): %s in %s on line %u';

        trigger_error(sprintf($error, $name, $trace[0]['file'], $trace[0]['line']), E_USER_NOTICE);
    }
}
