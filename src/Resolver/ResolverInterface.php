<?php

namespace OneSignal\Resolver;

interface ResolverInterface
{
    /**
     * Resolve options array.
     */
    public function resolve(array $data): array;
}
