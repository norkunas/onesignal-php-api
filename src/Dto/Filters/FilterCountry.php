<?php

declare(strict_types=1);

namespace OneSignal\Dto\Filters;

use OneSignal\Dto\AbstractDto;

class FilterCountry implements AbstractDto
{
    public const FIELD = 'country';

    public const EQ = '=';

    protected string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toArray(): array
    {
        return [
            'field' => self::FIELD,
            'relation' => self::EQ,
            'value' => $this->value,
        ];
    }
}
