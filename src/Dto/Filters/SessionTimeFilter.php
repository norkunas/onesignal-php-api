<?php

declare(strict_types=1);

namespace OneSignal\Dto\Filters;

class SessionTimeFilter extends AbstractFilter
{
    public const FIELD = 'session_time';

    public const GT = '>';

    public const LT = '<';

    /**
     * @var self::GT|self::LT
     */
    protected string $relation;

    protected int $value;

    /**
     * @param self::GT|self::LT $relation
     */
    public function __construct(string $relation, int $value)
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
