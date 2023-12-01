<?php

declare(strict_types=1);

namespace OneSignal\Dto\Filters;

use OneSignal\Dto\AbstractDto;

class FilterLocation implements AbstractDto
{
    public const FIELD = 'location';

    protected int $radius;

    /**
     * @var float<-90, 90>
     */
    protected float $lat;

    /**
     * @var float<-180, 180>
     */
    protected float $long;

    /**
     * @param float<-90, 90>   $lat
     * @param float<-180, 180> $long
     */
    public function __construct(int $radius, float $lat, float $long)
    {
        $this->radius = $radius;
        $this->lat = $lat;
        $this->long = $long;
    }

    public function toArray(): array
    {
        return [
            'field' => self::FIELD,
            'radius' => $this->radius,
            'lat' => $this->lat,
            'long' => $this->long,
        ];
    }
}
