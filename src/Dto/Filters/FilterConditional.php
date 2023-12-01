<?php

declare(strict_types=1);

namespace OneSignal\Dto\Filters;

use OneSignal\Dto\AbstractDto;

class FilterConditional implements AbstractDto
{
    public const AND = 'AND';

    public const OR = 'OR';

    /**
     * @var self::AND|self::OR
     */
    protected string $operator;

    /**
     * @param self::AND|self::OR $operator
     */
    public function __construct(string $operator)
    {
        $this->operator = $operator;
    }

    /**
     * @param self::AND|self::OR $operator
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
