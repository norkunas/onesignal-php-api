<?php

declare(strict_types=1);

namespace OneSignal\Dto\Segments;

use OneSignal\Dto\AbstractDto;
use OneSignal\Dto\Filters\FilterAmountSpent;
use OneSignal\Dto\Filters\FilterAppVersion;
use OneSignal\Dto\Filters\FilterBoughtSku;
use OneSignal\Dto\Filters\FilterConditional;
use OneSignal\Dto\Filters\FilterCountry;
use OneSignal\Dto\Filters\FilterFirstSession;
use OneSignal\Dto\Filters\FilterLanguage;
use OneSignal\Dto\Filters\FilterLastSession;
use OneSignal\Dto\Filters\FilterLocation;
use OneSignal\Dto\Filters\FilterSessionCount;
use OneSignal\Dto\Filters\FilterSessionTime;
use OneSignal\Dto\Filters\FilterTag;

class CreateSegment implements AbstractDto
{
    /**
     * @var non-empty-string
     */
    protected string $name;

    /**
     * @var array<int, FilterAmountSpent|FilterAppVersion|FilterBoughtSku|FilterConditional|FilterCountry|FilterFirstSession|FilterLanguage|FilterLastSession|FilterLocation|FilterSessionCount|FilterSessionTime|FilterTag>
     */
    protected array $filters = [];

    /**
     * @param non-empty-string                                                                                                                                                                                                 $name
     * @param array<int, FilterAmountSpent|FilterAppVersion|FilterBoughtSku|FilterConditional|FilterCountry|FilterFirstSession|FilterLanguage|FilterLastSession|FilterLocation|FilterSessionCount|FilterSessionTime|FilterTag> $filters
     */
    public function __construct(string $name, array $filters = [])
    {
        $this->name = $name;
        $this->filters = $filters;
    }

    /**
     * @param non-empty-string $name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param array<int, FilterAmountSpent|FilterAppVersion|FilterBoughtSku|FilterConditional|FilterCountry|FilterFirstSession|FilterLanguage|FilterLastSession|FilterLocation|FilterSessionCount|FilterSessionTime|FilterTag> $filters
     */
    public function setFilters(array $filters): self
    {
        $this->filters = $filters;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'filters' => array_map(static function (AbstractDto $filter): array {
                return $filter->toArray();
            }, $this->filters),
        ];
    }
}
