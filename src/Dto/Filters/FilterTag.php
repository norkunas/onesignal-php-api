<?php

declare(strict_types=1);

namespace OneSignal\Dto\Filters;

use OneSignal\Dto\AbstractDto;

class FilterTag implements AbstractDto
{
    public const FIELD = 'tag';

    public const GT = '>';

    public const LT = '<';

    public const EQ = '=';

    public const NEQ = '!=';

    public const EXISTS = 'exists';

    public const NOT_EXISTS = 'not_exists';

    public const TIME_ELAPSED_GT = 'time_elapsed_gt';

    public const TIME_ELAPSED_LT = 'time_elapsed_lt';

    /**
     * @var self::GT|self::LT|self::EQ|self::NEQ|self::EXISTS|self::NOT_EXISTS|self::TIME_ELAPSED_GT|self::TIME_ELAPSED_LT
     */
    protected string $relation;

    protected string $key;

    protected ?string $value = null;

    /**
     * @param self::GT|self::LT|self::EQ|self::NEQ|self::EXISTS|self::NOT_EXISTS|self::TIME_ELAPSED_GT|self::TIME_ELAPSED_LT $relation
     */
    public function __construct(string $relation, string $key, string $value = null)
    {
        $this->relation = $relation;
        $this->key = $key;
        $this->value = $value;
    }

    public function toArray(): array
    {
        return [
            'field' => self::FIELD,
            'relation' => $this->relation,
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}
