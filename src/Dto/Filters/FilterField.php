<?php

declare(strict_types=1);

namespace OneSignal\Dto\Filters;

use OneSignal\Dto\AbstractDto;

class FilterField implements AbstractDto
{
    /**
     * @var 'last_session'|'first_session'|'session_count'|'session_time'|'amount_spent'|'bought_sku'|'tag'|'language'|'app_version'|'location'|'country'
     */
    protected string $field;

    /**
     * @var string|int|float
     */
    protected $value;

    /**
     * @var array<string, string|int|float>
     */
    protected array $extraParams = [];

    /**
     * @param 'last_session'|'first_session'|'session_count'|'session_time'|'amount_spent'|'bought_sku'|'tag'|'language'|'app_version'|'location'|'country' $field
     * @param string|int|float                                                                                                                              $value
     * @param array<string, string|int|float>                                                                                                               $extraParams
     */
    public function __construct(string $field, $value, array $extraParams = [])
    {
        $this->field = $field;
        $this->value = $value;
        $this->extraParams = $extraParams;
    }

    /**
     * @param 'last_session'|'first_session'|'session_count'|'session_time'|'amount_spent'|'bought_sku'|'tag'|'language'|'app_version'|'location'|'country' $field
     */
    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @param string|int|float $value
     */
    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param array<string, string|int|float> $extraParams
     */
    public function setExtraParams(array $extraParams): self
    {
        $this->extraParams = $extraParams;

        return $this;
    }

    public function toArray(): array
    {
        $data = [
            'field' => $this->field,
            'value' => $this->value,
        ];

        return array_merge($data, $this->extraParams);
    }
}
