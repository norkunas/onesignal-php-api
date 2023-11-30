<?php

declare(strict_types=1);

namespace OneSignal\Dto\Segments;

use OneSignal\Dto\AbstractDto;

class ListSegments implements AbstractDto
{
    /**
     * @var int<0, 2147483648> $limit
     */
    protected int $limit;

    /**
     * @var int<0, 2147483648> $offset
     */
    protected int $offset;

    public function __construct(int $limit = 0, int $offset = 0)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function setLimit(int $limit = 0): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function setOffset(int $offset = 0): self
    {
        $this->offset = $offset;

        return $this;
    }

    public function toArray(): array
    {
        $query = [];

        if ($this->limit > 0) {
            $query['limit'] = $this->limit;
        }

        if ($this->offset > 0) {
            $query['offset'] = $this->offset;
        }

        return $query;
    }
}
