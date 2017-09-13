<?php

namespace OneSignal\Tests;

trait PrivateAccessorTrait
{
    public function getPrivateMethod($class, $method)
    {
        $class = new \ReflectionClass($class);
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        return $method;
    }
}
