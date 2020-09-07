<?php

declare(strict_types=1);

namespace OneSignal\Tests;

trait PrivateAccessorTrait
{
    /**
     * @param class-string $class
     */
    public function getPrivateMethod(string $class, string $method): \ReflectionMethod
    {
        $class = new \ReflectionClass($class);
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        return $method;
    }
}
