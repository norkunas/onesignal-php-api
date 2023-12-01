<?php

declare(strict_types=1);

namespace OneSignal\Dto\Filters;

class LastSessionFilter extends AbstractFilter
{
    public const FIELD = 'last_session';

    public const GT = '>';

    public const LT = '<';

    /**
     * @var self::GT|self::LT
     */
    protected string $relation;

    /**
     * @var int|float
     */
    protected $hoursAgo;

    /**
     * @param self::GT|self::LT $relation
     * @param int|float         $hoursAgo
     */
    public function __construct(string $relation, $hoursAgo)
    {
        $this->relation = $relation;
        $this->hoursAgo = $hoursAgo;
    }

    public function toArray(): array
    {
        return [
            'field' => self::FIELD,
            'relation' => $this->relation,
            'hours_ago' => $this->hoursAgo,
        ];
    }
}
