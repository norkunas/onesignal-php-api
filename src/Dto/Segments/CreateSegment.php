<?php

declare(strict_types=1);

namespace OneSignal\Dto\Segments;

use OneSignal\Dto\AbstractDto;

class CreateSegment implements AbstractDto
{
    /**
     * @var non-empty-string $name
     */
    protected string $name;

    /**
     * @param array<int, array> $filters
     */
    protected array $filters = [];

    /**
     * @param array<int, array> $filters
     */
    public function __construct(string $name, array $filters = [])
    {
        $this->name = $name;
        $this->filters = $filters;
    }

    /**
     * @var non-empty-string $name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param array<int, array> $filters
     */
    public function setFilters(array $filters = []): self
    {
        $this->filters = $filters;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'filters' => $this->filters,
        ];
    }
}
