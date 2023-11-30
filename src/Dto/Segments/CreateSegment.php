<?php

declare(strict_types=1);

namespace OneSignal\Dto\Segments;

use OneSignal\Dto\AbstractDto;

class CreateSegment implements AbstractDto
{
    /**
     * @var non-empty-string
     */
    protected string $name;

    /**
     * @var array<int, array>
     */
    protected array $filters = [];

    /**
     * @param non-empty-string $name
     * @param array<int, array> $filters
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
