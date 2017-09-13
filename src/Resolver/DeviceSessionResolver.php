<?php

namespace OneSignal\Resolver;

use Symfony\Component\OptionsResolver\OptionsResolver;

class DeviceSessionResolver implements ResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function resolve(array $data)
    {
        return (new OptionsResolver())
            ->setDefined('identifier')
            ->setAllowedTypes('identifier', 'string')
            ->setDefined('language')
            ->setAllowedTypes('language', 'string')
            ->setDefined('timezone')
            ->setAllowedTypes('timezone', 'int')
            ->setDefined('game_version')
            ->setAllowedTypes('game_version', 'string')
            ->setDefined('device_os')
            ->setAllowedTypes('device_os', 'string')
            // @todo: remove "device_model" later (this option is probably deprecated as it is removed from documentation)
            ->setDefined('device_model')
            ->setAllowedTypes('device_model', 'string')
            ->setDefined('ad_id')
            ->setAllowedTypes('ad_id', 'string')
            ->setDefined('sdk')
            ->setAllowedTypes('sdk', 'string')
            ->setDefined('tags')
            ->setAllowedTypes('tags', 'array')
            ->resolve($data);
    }
}
