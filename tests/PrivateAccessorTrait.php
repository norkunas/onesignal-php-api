<?php

declare(strict_types=1);

namespace OneSignal\Tests;

use ReflectionClass;
use ReflectionMethod;

use const PHP_VERSION_ID;

trait PrivateAccessorTrait
{
    /**
     * @param class-string $class
     */
    public function getPrivateMethod(string $class, string $method): ReflectionMethod
    {
        $class = new ReflectionClass($class);
        $method = $class->getMethod($method);

        if (PHP_VERSION_ID < 80100) {
            $method->setAccessible(true);
        }

        return $method;
    }
}
