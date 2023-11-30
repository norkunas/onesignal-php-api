<?php

declare(strict_types=1);

namespace OneSignal\Dto\Support;

use OneSignal\Dto\AbstractDto;

class Pagination implements AbstractDto
{
    protected ?int $limit;

    protected ?int $offset;

    public function __construct(?int $limit = null, ?int $offset = null)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function setLimit(?int $limit = null): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function setOffset(?int $offset = null): self
    {
        $this->offset = $offset;

        return $this;
    }

    public function toArray(): array
    {
        $query = [];

        if ($this->limit !== null) {
            $query['limit'] = $this->limit;
        }

        if ($this->offset !== null) {
            $query['offset'] = $this->offset;
        }

        return $query;
    }
}
