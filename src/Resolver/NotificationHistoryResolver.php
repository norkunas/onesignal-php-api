<?php

namespace OneSignal\Resolver;

use Symfony\Component\OptionsResolver\OptionsResolver;

class NotificationHistoryResolver implements ResolverInterface
{
    /**
     * {@inheritdoc}
     */
    public function resolve(array $data)
    {
        return (new OptionsResolver())
            ->setRequired('events')
            ->setAllowedTypes('events', 'string')
            ->setAllowedValues('events', ['sent', 'clicked'])
            ->setRequired('email')
            ->setAllowedTypes('email', 'string')
            ->resolve($data);
    }
}
