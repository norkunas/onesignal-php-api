<?php

declare(strict_types=1);

namespace OneSignal\Dto\Filter;

final class SessionCountFilter extends AbstractFilter
{
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
            'field' => 'session_count',
            'relation' => $this->relation,
            'value' => $this->value,
        ];
    }
}
