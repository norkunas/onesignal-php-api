<?php

declare(strict_types=1);

namespace OneSignal\Dto\Filters;

use OneSignal\Dto\AbstractDto;

class FilterAmountSpent implements AbstractDto
{
    public const FIELD = 'amount_spent';

    public const GT = '>';

    public const LT = '<';

    public const EQ = '=';

    /**
     * @var self::GT|self::LT|self::EQ
     */
    protected string $relation;

    /**
     * @var int|float
     */
    protected $value;

    /**
     * @param self::GT|self::LT|self::EQ $relation
     * @param int|float                  $value
     */
    public function __construct(string $relation, $value)
    {
        $this->relation = $relation;
        $this->value = $value;
    }

    public function toArray(): array
    {
        return [
            'field' => self::FIELD,
            'relation' => $this->relation,
            'value' => $this->value,
        ];
    }
}
