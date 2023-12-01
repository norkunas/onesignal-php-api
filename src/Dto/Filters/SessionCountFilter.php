<?php

declare(strict_types=1);

namespace OneSignal\Dto\Filters;

class SessionCountFilter extends AbstractFilter
{
    public const FIELD = 'session_count';

    public const GT = '>';

    public const LT = '<';

    public const EQ = '=';

    public const NEQ = '!=';

    /**
     * @var self::GT|self::LT|self::EQ|self::NEQ
     */
    protected string $relation;

    protected int $value;

    /**
     * @param self::GT|self::LT|self::EQ|self::NEQ $relation
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
