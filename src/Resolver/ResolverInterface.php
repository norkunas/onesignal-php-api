<?php

namespace OneSignal\Resolver;

interface ResolverInterface
{
    /**
     * Resolve option array.
     *
     * @param array $data
     *
     * @return array
     */
    public function resolve(array $data);
}
