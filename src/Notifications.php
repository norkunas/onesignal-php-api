<?php
namespace OneSignal;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Notifications
{
    /**
     * @var OneSignal
     */
    protected $api;

    /**
     * Constructor
     *
     * @param OneSignal $api
     */
    public function __construct(OneSignal $api)
    {
        $this->api = $api;
    }

    public function getOne($id)
    {
        $url = '/notifications/' . $id . '?app_id=' . $this->api->getConfig()->getApplicationId();

        return $this->api->request('GET', $url, [
            'headers' => [
                'Authorization' => 'Basic ' . $this->api->getConfig()->getApplicationAuthKey(),
            ],
        ]);
    }

    public function getAll($limit = null, $offset = null)
    {
        return $this->api->request('GET', '/notifications?' . http_build_query([
             'limit' => max(0, min(50, filter_var($limit, FILTER_VALIDATE_INT))),
             'offset' => max(0, min(50, filter_var($offset, FILTER_VALIDATE_INT))),
        ]), [
            'headers' => [
                'Authorization' => 'Basic ' . $this->api->getConfig()->getApplicationAuthKey(),
            ],
            'json' => [
                'app_id' => $this->api->getConfig()->getApplicationId(),
            ],
        ]);
    }

    public function add(array $data)
    {
        $data = $this->resolve($data);
var_dump($data);exit;
        return $this->api->request('POST', '/notifications', [
            'headers' => [
                'Authorization' => 'Basic ' . $this->api->getConfig()->getApplicationAuthKey(),
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);
    }

    public function open($id)
    {
        return $this->api->request('PUT', '/notifications/' . $id, [
            'headers' => [
                'Authorization' => 'Basic ' . $this->api->getConfig()->getApplicationAuthKey(),
            ],
            'json' => [
                'app_id' => $this->api->getConfig()->getApplicationId(),
                'opened' => true,
            ],
        ]);
    }

    public function cancel($id)
    {
        return $this->api->request('DELETE', '/notifications/' . $id, [
            'headers' => [
                'Authorization' => 'Basic ' . $this->api->getConfig()->getApplicationAuthKey(),
            ],
            'json' => [
                'app_id' => $this->api->getConfig()->getApplicationId(),
            ],
        ]);
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
            ->setAllowedTypes('tags', 'array')
            ->setNormalizer('tags', function (Options $options, $value) {
                $tags = [];

                foreach ($value as $tag) {
                    if (!isset($tag['key'], $tag['relation'], $tag['value'])) {
                        continue;
                    }
                    // @todo: values must be passed as string so make a validation or cast them to string
                    $tags[] = [
                        'key' => $tag['key'],
                        'relation' => $tag['relation'],
                        'value' => $tag['value'],
                    ];
                }

                return $tags;
            })
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
            ->setAllowedTypes('template_id', 'string')
            ->setDefault('app_id', $this->api->getConfig()->getApplicationId());

        return $resolver->resolve($data);
    }
}
