<?php

declare(strict_types=1);

namespace OneSignal\Response\Segment;

use OneSignal\Response\AbstractResponse;

final class CreateSegmentResponse implements AbstractResponse
{
    protected bool $success;

    /**
     * @var non-empty-string
     */
    protected string $id;

    /**
     * @param non-empty-string $id
     */
    public function __construct(bool $success, string $id)
    {
        $this->success = $success;
        $this->id = $id;
    }

    public static function makeFromResponse(array $request): self
    {
        return new static(
            $request['success'],
            $request['id']
        );
    }

    public function getSuccess(): bool
    {
        return $this->success;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
