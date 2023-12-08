<?php

declare(strict_types=1);

namespace OneSignal\Dto\Filter;

final class LocationFilter extends AbstractFilter
{
    protected int $radius;

    protected float $lat;

    protected float $long;

    public function __construct(int $radius, float $lat, float $long)
    {
        $this->radius = $radius;
        $this->lat = $lat;
        $this->long = $long;
    }

    public function toArray(): array
    {
        return [
            'field' => 'location',
            'radius' => $this->radius,
            'lat' => $this->lat,
            'long' => $this->long,
        ];
    }
}
