<?php

declare(strict_types=1);

namespace OneSignal\Dto;

interface AbstractDto
{
    public function toArray(): array;
}
