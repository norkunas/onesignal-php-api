<?php

declare(strict_types=1);

namespace OneSignal\Tests;

trait PrivateAccessorTrait
{
    public function getPrivateMethod($class, $method): \ReflectionMethod
    {
        $class = new \ReflectionClass($class);
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        return $method;
    }
}
