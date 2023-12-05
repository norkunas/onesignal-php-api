<?php

declare(strict_types=1);

namespace OneSignal\Response;

interface AbstractResponse
{
    public static function makeFromResponse(array $request): self;
}
