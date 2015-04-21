<?php
namespace OneSignal;

/**
 * @property-read Apps          $apps
 * @property-read Devices       $devices
 * @property-read Notifications $notifications
 */
class OneSignal
{
    const API_URL = 'https://onesignal.com/api/v1';

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $httpClient;

    /**
     * @var array
     */
    protected $services = [];

    /**
     * Constructor
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->httpClient = new \GuzzleHttp\Client([
            'defaults' => [
                'headers' => [
                    'Accept' => 'application/json',
                ],
            ],
        ]);
        /*$this->client = $guzzle ?: new Client([
            'base_url' => ['https://onesignal.com/api/{version}', ['version' => 'v1']],
        ]);*/
    }

    /**
     * Set http client
     *
     * @param \GuzzleHttp\Client $httpClient
     */
    public function setHttpClient(\GuzzleHttp\Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * Get http client
     *
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient()
    {
        return $this->httpClient;
    }

    /**
     * Create required services on the fly
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

            $this->services[$name] = new $serviceName($this->client, $this->httpClient);

            return $this->services[$name];
        }

        $trace = debug_backtrace();

        $error = 'Undefined property via __get(): %s in %s on line %u';

        trigger_error(sprintf($error, $name, $trace[0]['file'], $trace[0]['line']), E_USER_NOTICE);

        return null;
    }
}
