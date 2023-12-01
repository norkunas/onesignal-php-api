<?php

declare(strict_types=1);

namespace OneSignal\Dto\Filters;

class LanguageFilter extends AbstractFilter
{
    public const FIELD = 'language';

    public const EQ = '=';

    public const NEQ = '!=';

    /**
     * @var self::EQ|self::NEQ
     */
    protected string $relation;

    protected string $value;

    /**
     * @param self::EQ|self::NEQ $relation
     */
    public function __construct(string $relation, string $value)
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
