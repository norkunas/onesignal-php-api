<?php

declare(strict_types=1);

namespace OneSignal\Dto\Segments;

use OneSignal\Dto\AbstractDto;
use OneSignal\Dto\Filters\FilterConditional;
use OneSignal\Dto\Filters\FilterField;

class CreateSegment implements AbstractDto
{
    /**
     * @var non-empty-string
     */
    protected string $name;

    /**
     * @var array<int, FilterField|FilterConditional>
     */
    protected array $filters = [];

    /**
     * @param non-empty-string                          $name
     * @param array<int, FilterField|FilterConditional> $filters
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
     * @param array<int, FilterField|FilterConditional> $filters
     */
    public function setFilters(array $filters): self
    {
        $this->filters = $filters;

        return $this;
    }

    public function toArray(): array
    {
        foreach ($this->filters as &$filter) {
            $filter = $filter->toArray();
        }

        return [
            'name' => $this->name,
            'filters' => $this->filters,
        ];
    }
}
