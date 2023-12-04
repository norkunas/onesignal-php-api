<?php

declare(strict_types=1);

namespace OneSignal\Dto\Filters;

final class AppVersionFilter extends AbstractFilter
{
    public const GT = '>';

    public const LT = '<';

    public const EQ = '=';

    public const NEQ = '!=';

    /**
     * @var self::GT|self::LT|self::EQ|self::NEQ
     */
    protected string $relation;

    protected string $value;

    /**
     * @param self::GT|self::LT|self::EQ|self::NEQ $relation
     */
    public function __construct(string $relation, string $value)
    {
        $this->relation = $relation;
        $this->value = $value;
    }

    public function toArray(): array
    {
        return [
            'field' => 'app_version',
            'relation' => $this->relation,
            'value' => $this->value,
        ];
    }
}
