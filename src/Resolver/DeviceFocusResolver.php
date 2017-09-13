<?php

namespace OneSignal\Resolver;

use Symfony\Component\OptionsResolver\OptionsResolver;

class DeviceFocusResolver implements ResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function resolve(array $data)
    {
        return (new OptionsResolver())
            ->setDefault('state', 'ping')
            ->setAllowedTypes('state', 'string')
            ->setRequired('active_time')
            ->setAllowedTypes('active_time', 'int')
            ->resolve($data);
    }
}
