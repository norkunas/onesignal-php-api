<?php

namespace OneSignal;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Notifications
{
    const NOTIFICATIONS_LIMIT = 50;

    protected $api;

    public function __construct(OneSignal $api)
    {
        $this->api = $api;
    }

    /**
     * Get information about notification with provided ID.
     *
     * Application authentication key and ID must be set.
     *
     * @param string $id Notification ID
     *
     * @return array
     */
    public function getOne($id)
    {
        $url = '/notifications/'.$id.'?app_id='.$this->api->getConfig()->getApplicationId();

        return $this->api->request('GET', $url, [
            'Authorization' => 'Basic '.$this->api->getConfig()->getApplicationAuthKey(),
        ]);
    }

    /**
     * Get information about all notifications.
     *
     * Application authentication key and ID must be set.
     *
     * @param int $limit  How many notifications to return (max 50)
     * @param int $offset Results offset (results are sorted by ID)
     *
     * @return array
     */
    public function getAll($limit = self::NOTIFICATIONS_LIMIT, $offset = 0)
    {
        $query = [
            'limit' => max(1, min(self::NOTIFICATIONS_LIMIT, filter_var($limit, FILTER_VALIDATE_INT))),
            'offset' => max(0, filter_var($offset, FILTER_VALIDATE_INT)),
            'app_id' => $this->api->getConfig()->getApplicationId(),
        ];

        return $this->api->request('GET', '/notifications?'.http_build_query($query), [
            'Authorization' => 'Basic '.$this->api->getConfig()->getApplicationAuthKey(),
        ]);
    }

    /**
     * Send new notification with provided data.
     *
     * Application authentication key and ID must be set.
     *
     * @param array $data
     *
     * @return array
     */
    public function add(array $data)
    {
        return $this->api->request('POST', '/notifications', [
            'Authorization' => 'Basic '.$this->api->getConfig()->getApplicationAuthKey(),
        ], json_encode($this->resolve($data)));
    }

    /**
     * Open notification.
     *
     * Application authentication key and ID must be set.
     *
     * @param string $id Notification ID
     *
     * @return array
     */
    public function open($id)
    {
        return $this->api->request('PUT', '/notifications/'.$id, [
            'Authorization' => 'Basic '.$this->api->getConfig()->getApplicationAuthKey(),
        ], json_encode([
            'app_id' => $this->api->getConfig()->getApplicationId(),
            'opened' => true,
        ]));
    }

    /**
     * Cancel notification.
     *
     * Application authentication key and ID must be set.
     *
     * @param string $id Notification ID
     *
     * @return array
     */
    public function cancel($id)
    {
        $url = '/notifications/'.$id.'?app_id='.$this->api->getConfig()->getApplicationId();

        return $this->api->request('DELETE', $url, [
            'Authorization' => 'Basic '.$this->api->getConfig()->getApplicationAuthKey(),
        ]);
    }

    protected function resolve(array $data)
    {
        $resolver = new OptionsResolver();

        $resolver
            ->setDefined('contents')
            ->setAllowedTypes('contents', 'array')
            ->setDefined('headings')
            ->setAllowedTypes('headings', 'array')
            ->setDefined('subtitle')
            ->setAllowedTypes('subtitle', 'array')
            ->setDefined('isIos')
            ->setAllowedTypes('isIos', 'bool')
            ->setDefined('isAndroid')
            ->setAllowedTypes('isAndroid', 'bool')
            ->setDefined('isWP')
            ->setAllowedTypes('isWP', 'bool')
            ->setDefined('isWP_WNS')
            ->setAllowedTypes('isWP_WNS', 'bool')
            ->setDefined('isAdm')
            ->setAllowedTypes('isAdm', 'bool')
            ->setDefined('isChrome')
            ->setAllowedTypes('isChrome', 'bool')
            ->setDefined('isChromeWeb')
            ->setAllowedTypes('isChromeWeb', 'bool')
            ->setDefined('isFirefox')
            ->setAllowedTypes('isFirefox', 'bool')
            ->setDefined('isSafari')
            ->setAllowedTypes('isSafari', 'bool')
            ->setDefined('isAnyWeb')
            ->setAllowedTypes('isAnyWeb', 'bool')
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
            ->setDefined('include_wp_uris')
            ->setAllowedTypes('include_wp_uris', 'array')
            ->setDefined('include_wp_wns_uris')
            ->setAllowedTypes('include_wp_wns_uris', 'array')
            ->setDefined('include_amazon_reg_ids')
            ->setAllowedTypes('include_amazon_reg_ids', 'array')
            ->setDefined('include_chrome_reg_ids')
            ->setAllowedTypes('include_chrome_reg_ids', 'array')
            ->setDefined('include_chrome_web_reg_ids')
            ->setAllowedTypes('include_chrome_web_reg_ids', 'array')
            ->setDefined('app_ids')
            ->setAllowedTypes('app_ids', 'array')
            ->setDefined('filters')
            ->setAllowedTypes('filters', 'array')
            ->setNormalizer('filters', function (Options $options, array $value) {
                $filters = [];

                foreach ($value as $filter) {
                    if (isset($filter['field'])) {
                        $filters[] = $filter;
                    } elseif (isset($filter['operator'])) {
                        $filters[] = ['operator' => 'OR'];
                    }
                }

                return $filters;
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
            ->setDefined('adm_sound')
            ->setAllowedTypes('adm_sound', 'string')
            ->setDefined('wp_sound')
            ->setAllowedTypes('wp_sound', 'string')
            ->setDefined('wp_wns_sound')
            ->setAllowedTypes('wp_wns_sound', 'string')
            ->setDefined('data')
            ->setAllowedTypes('data', 'array')
            ->setDefined('buttons')
            ->setAllowedTypes('buttons', 'array')
            ->setNormalizer('buttons', function (Options $options, array $value) {
                $buttons = [];

                foreach ($value as $button) {
                    if (!isset($button['text'])) {
                        continue;
                    }

                    $buttons[] = [
                        'id' => (isset($button['id']) ? $button['id'] : mt_rand()),
                        'text' => $button['text'],
                        'icon' => (isset($button['icon']) ? $button['icon'] : null),
                    ];
                }

                return $buttons;
            })
            ->setDefined('android_background_layout')
            ->setAllowedValues('android_background_layout', 'array')
            ->setAllowedValues('android_background_layout', function ($layout) {
                if (empty($layout)) {
                    return false;
                }

                $requiredKeys = ['image', 'headings_color', 'contents_color'];

                foreach ($layout as $k => $v) {
                    if (!in_array($k, $requiredKeys) || !is_string($v)) {
                        return false;
                    }
                }

                return true;
            })
            ->setDefined('small_icon')
            ->setAllowedTypes('small_icon', 'string')
            ->setDefined('large_icon')
            ->setAllowedTypes('large_icon', 'string')
            ->setDefined('ios_attachments')
            ->setAllowedTypes('ios_attachments', 'array')
            ->setAllowedValues('ios_attachments', function ($attachments) {
                foreach ($attachments as $key => $value) {
                    if (!is_string($key) || !is_string($value)) {
                        return false;
                    }
                }

                return true;
            })
            ->setDefined('big_picture')
            ->setAllowedTypes('big_picture', 'string')
            ->setDefined('adm_small_icon')
            ->setAllowedTypes('adm_small_icon', 'string')
            ->setDefined('adm_large_icon')
            ->setAllowedTypes('adm_large_icon', 'string')
            ->setDefined('adm_big_picture')
            ->setAllowedTypes('adm_big_picture', 'string')
            ->setDefined('web_buttons')
            ->setAllowedTypes('web_buttons', 'array')
            ->setAllowedValues('web_buttons', function ($buttons) {
                $requiredKeys = ['id', 'text', 'icon', 'url'];
                foreach ($buttons as $button) {
                    if (!is_array($button)) {
                        return false;
                    }
                    if (count(array_intersect_key(array_flip($requiredKeys), $button)) != count($requiredKeys)) {
                        return false;
                    }
                }

                return true;
            })
            ->setDefined('ios_category')
            ->setAllowedTypes('ios_category', 'string')
            ->setDefined('chrome_icon')
            ->setAllowedTypes('chrome_icon', 'string')
            ->setDefined('chrome_big_picture')
            ->setAllowedTypes('chrome_big_picture', 'string')
            ->setDefined('chrome_web_icon')
            ->setAllowedTypes('chrome_web_icon', 'string')
            ->setDefined('chrome_web_image')
            ->setAllowedTypes('chrome_web_image', 'string')
            ->setDefined('firefox_icon')
            ->setAllowedTypes('firefox_icon', 'string')
            ->setDefined('url')
            ->setAllowedTypes('url', 'string')
            ->setAllowedValues('url', function ($value) {
                return (bool) filter_var($value, FILTER_VALIDATE_URL);
            })
            ->setDefined('send_after')
            ->setAllowedTypes('send_after', '\DateTimeInterface')
            ->setNormalizer('send_after', function (Options $options, \DateTime $value) {
                //"2015-09-24 14:00:00 GMT-0700"
                return $value->format('Y-m-d H:i:s TO');
            })
            ->setDefined('delayed_option')
            ->setAllowedTypes('delayed_option', 'string')
            ->setAllowedValues('delayed_option', ['timezone', 'last-active'])
            ->setDefined('delivery_time_of_day')
            ->setAllowedTypes('delivery_time_of_day', '\DateTimeInterface')
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
            ->setDefined('collapse_id')
            ->setAllowedTypes('collapse_id', 'string')
            ->setDefined('content_available')
            ->setAllowedTypes('content_available', 'bool')
            ->setDefined('mutable_content')
            ->setAllowedTypes('mutable_content', 'bool')
            ->setDefined('android_background_data')
            ->setAllowedTypes('android_background_data', 'bool')
            ->setDefined('amazon_background_data')
            ->setAllowedTypes('amazon_background_data', 'bool')
            ->setDefined('template_id')
            ->setAllowedTypes('template_id', 'string')
            ->setDefined('android_group')
            ->setAllowedTypes('android_group', 'string')
            ->setDefined('android_group_message')
            ->setAllowedTypes('android_group_message', 'array')
            ->setDefined('adm_group')
            ->setAllowedTypes('adm_group', 'string')
            ->setDefined('adm_group_message')
            ->setAllowedTypes('adm_group_message', 'array')
            ->setDefined('ttl')
            ->setAllowedTypes('ttl', 'int')
            ->setDefined('priority')
            ->setAllowedTypes('priority', 'int')
            ->setDefault('app_id', $this->api->getConfig()->getApplicationId());

        return $resolver->resolve($data);
    }
}
