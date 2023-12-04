<?php

declare(strict_types=1);

namespace OneSignal\Dto\Filters;

final class BoughtSkuFilter extends AbstractFilter
{
    public const GT = '>';

    public const LT = '<';

    public const EQ = '=';

    /**
     * @var self::GT|self::LT|self::EQ
     */
    protected string $relation;

    protected string $key;

    /**
     * @var int|float
     */
    protected $value;

    /**
     * @param self::GT|self::LT|self::EQ $relation
     * @param int|float                  $value
     */
    public function __construct(string $relation, string $key, $value)
    {
        $this->relation = $relation;
        $this->key = $key;
        $this->value = $value;
    }

    public function toArray(): array
    {
        return [
            'field' => 'bought_sku',
            'relation' => $this->relation,
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}
