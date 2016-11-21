<?php

namespace OneSignal;

use Http\Client\Common\HttpMethodsClient as Client;
use OneSignal\Exception\OneSignalException;
use Psr\Http\Message\StreamInterface;

/**
 * @property-read Apps          $apps          Applications API service
 * @property-read Devices       $devices       Devices API service
 * @property-read Notifications $notifications Notifications API service
 */
class OneSignal
{
    const API_URL = 'https://onesignal.com/api/v1';

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $services = [];

    /**
     * Constructor.
     *
     * @param Config $config
     * @param Client $client
     */
    public function __construct(Config $config = null, Client $client = null)
    {
        $this->config = ($config ?: new Config());

        if (null !== $client) {
            $this->client = $client;
        }
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
     * @return Client|null
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Make a custom api request.
     *
     * @param string                      $method  HTTP Method
     * @param string                      $uri     URI template
     * @param array                       $headers
     * @param string|StreamInterface|null $body
     *
     * @throws OneSignalException
     *
     * @return array
     */
    public function request($method, $uri, array $headers = [], $body = null)
    {
        try {
            $response = $this->client->send($method, self::API_URL.$uri, array_merge([
                'Content-Type' => 'application/json',
            ], $headers), $body);

            return json_decode($response->getBody(), true);
        } catch (\Throwable $t) {
            throw new OneSignalException($t->getMessage());
        } catch (\Exception $e) {
            throw new OneSignalException($e->getMessage());
        }
    }

    /**
     * Create required services on the fly.
     *
     * @param string $name
     *
     * @return object
     *
     * @throws OneSignalException If an invalid service name is given
     */
    public function __get($name)
    {
        if (in_array($name, ['apps', 'devices', 'notifications'], true)) {
            if (isset($this->services[$name])) {
                return $this->services[$name];
            }

            $serviceName = __NAMESPACE__.'\\'.ucfirst($name);

            $this->services[$name] = new $serviceName($this);

            return $this->services[$name];
        }

        $trace = debug_backtrace();

        throw new OneSignalException(sprintf('Undefined property via __get(): %s in %s on line %u', $name, $trace[0]['file'], $trace[0]['line']));
    }
}
