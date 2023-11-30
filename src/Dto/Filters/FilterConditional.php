<?php

declare(strict_types=1);

namespace OneSignal\Dto\Filters;

use OneSignal\Dto\AbstractDto;

class FilterConditional implements AbstractDto
{
    /**
     * @var 'AND'|'OR'
     */
    protected string $operator;

    public function __construct(string $operator)
    {
        $this->operator = $operator;
    }

    /**
     * @param 'AND'|'OR' $operator
     */
    public function setOperator(string $operator): self
    {
        $this->operator = $operator;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'operator' => $this->operator,
        ];
    }
}
