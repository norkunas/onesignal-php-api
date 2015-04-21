<?php
namespace OneSignal;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Notifications
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * Constructor
     *
     * @param Client             $client
     * @param \GuzzleHttp\Client $guzzle
     */
    public function __construct(Client $client, \GuzzleHttp\Client $guzzle)
    {
        $this->client = $client;
        $this->http = $guzzle;
    }

    public function getOne($id)
    {
        return $this->http->get('https://onesignal.com/api/v1/notifications/' . $id . '?app_id=' . $this->client->getApplicationId(), [
            'headers' => [
                'Authorization' => 'Basic ' . $this->client->getApplicationAuthKey(),
            ],
        ])->json();
    }

    public function getAll($limit = null, $offset = null)
    {
        $url = 'https://onesignal.com/api/v1/notifications/?app_id=' . $this->client->getApplicationId();

        if ($limit) {
            $url .= '&limit=' . $limit;
        }

        if ($offset) {
            $url .= '&offset=' . $offset;
        }

        return $this->http->get($url, [
            'headers' => [
                'Authorization' => 'Basic ' . $this->client->getApplicationAuthKey(),
            ],
        ])->json();
    }

    public function add(array $data)
    {
        $data = $this->resolve($data);

        $headers = [
            'Content-Type' => 'application/json',
        ];

        if (isset($data['include_segments']) || isset($data['tags'])) {
            $headers['Authorization'] = $this->client->getApplicationAuthKey();
        }

        return $this->http->post('https://onesignal.com/api/v1/notifications', [
            'headers' => $headers,
            'json' => $data,
        ])->json();
    }

    public function cancel($id)
    {
        return $this->http->delete('https://onesignal.com/api/v1/notifications/' . $id . '?app_id=' . $this->client->getApplicationId(), [
            'headers' => [
                'Authorization' => 'Basic ' . $this->client->getApplicationAuthKey(),
            ],
        ])->json();
    }

    public function open($id)
    {
        return $this->http->put('https://onesignal.com/api/v1/notifications/' . $id . '?app_id=' . $this->client->getApplicationId(), [
            'headers' => [
                'Authorization' => 'Basic ' . $this->client->getApplicationAuthKey(),
            ],
            'json' => [
                'opened' => true,
            ]
        ])->json();
    }

    protected function resolve(array $data)
    {
        $resolver = new OptionsResolver();

        $resolver
            ->setDefined('contents')
            ->setDefined('headings')
            ->setDefined('isIos')
            ->setAllowedTypes('isIos', 'bool')
            ->setDefined('isAndroid')
            ->setAllowedTypes('isAndroid', 'bool')
            ->setDefined('isWP')
            ->setAllowedTypes('isWP', 'bool')
            ->setDefined('isAdm')
            ->setAllowedTypes('isAdm', 'bool')
            ->setDefined('isChrome')
            ->setAllowedTypes('isChrome', 'bool')
            ->setDefined('included_segments')
            ->setAllowedTypes('included_segments', 'array')
            ->setDefined('excluded_segments')
            ->setAllowedTypes('excluded_segments', 'array')
            ->setDefined('include_player_ids')
            ->setAllowedTypes('include_player_ids', 'array')
            ->setDefined('include_ios_tokens')
            ->setAllowedTypes('include_ios_tokens', 'array')
            ->setDefined('include_android_reg_ids')
            ->setAllowedTypes('include_android_reg_ids', 'array')
            ->setDefined('include_wp_urls')
            ->setAllowedTypes('include_wp_urls', 'array')
            ->setDefined('include_amazon_reg_ids')
            ->setAllowedTypes('include_amazon_reg_ids', 'array')
            ->setDefined('include_chrome_reg_ids')
            ->setAllowedTypes('include_chrome_reg_ids', 'array')
            ->setDefined('tags')

            ->setDefined('ios_badgeType')
            ->setAllowedTypes('ios_badgeType', 'string')
            ->setAllowedValues('ios_badgeType', ['None', 'SetTo', 'Increase'])
            ->setDefined('ios_badgeCount')
            ->setAllowedTypes('ios_badgeCount', 'int')
            ->setDefined('ios_sound')
            ->setAllowedTypes('ios_sound', 'string')
            ->setDefined('android_sound')
            ->setAllowedTypes('android_sound', 'string')
            ->setDefined('wp_sound')
            ->setAllowedTypes('wp_sound', 'string')
            ->setDefined('data')
            ->setAllowedTypes('data', 'array')
            ->setDefined('buttons')

            ->setDefined('small_icon')
            ->setAllowedTypes('small_icon', 'string')
            ->setDefined('large_icon')
            ->setAllowedTypes('large_icon', 'string')
            ->setDefined('big_picture')
            ->setAllowedTypes('big_picture', 'string')
            ->setDefined('adm_small_icon')
            ->setAllowedTypes('adm_small_icon', 'string')
            ->setDefined('adm_large_icon')
            ->setAllowedTypes('adm_large_icon', 'string')
            ->setDefined('adm_big_picture')
            ->setAllowedTypes('adm_big_picture', 'string')
            ->setDefined('chrome_icon')
            ->setAllowedTypes('chrome_icon', 'string')
            ->setDefined('chrome_big_picture')
            ->setAllowedTypes('chrome_big_picture', 'string')
            ->setDefined('url')
            ->setAllowedTypes('url', 'string')
            ->setDefined('send_after')
            ->setAllowedTypes('send_after', '\DateTime')
            ->setNormalizer('send_after', function (Options $options, \DateTime $value) {
                //Fri May 02 2014 00:00:00 GMT-0700 (PDT)
                return $value->format('D M d Y H:i:s eO (T)');
            })
            ->setDefined('delayed_option')
            ->setAllowedTypes('delayed_option', 'string')
            ->setAllowedValues('delayed_option', ['timezone', 'last-active'])
            ->setDefined('delivery_time_of_day')
            ->setAllowedTypes('delivery_time_of_day', '\DateTime')
            ->setNormalizer('delivery_time_of_day', function (Options $options, \DateTime $value) {
                return $value->format('g:iA');
            })
            ->setDefined('android_led_color')
            ->setAllowedTypes('android_led_color', 'string')
            ->setDefined('android_accent_color')
            ->setAllowedTypes('android_accent_color', 'string')
            ->setDefined('android_visibility')
            ->setAllowedTypes('android_visibility', 'int')
            ->setAllowedValues('android_visibility', [-1, 0, 1])
            ->setDefined('content_available')
            ->setAllowedTypes('content_available', 'bool')
            ->setDefined('android_background_data')
            ->setAllowedTypes('android_background_data', 'bool')
            ->setDefined('amazon_background_data')
            ->setAllowedTypes('amazon_background_data', 'bool')
            ->setDefined('template_id')
            ->setAllowedTypes('template_id', 'string');

        $resolver->setDefault('app_id', $this->client->getApplicationId());

        return $resolver->resolve($data);
    }
}
