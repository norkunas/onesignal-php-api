<?php

declare(strict_types=1);

namespace OneSignal\Response\Segment;

use OneSignal\Response\AbstractResponse;

final class DeleteSegmentResponse implements AbstractResponse
{
    protected bool $success;

    public function __construct(bool $success)
    {
        $this->success = $success;
    }

    public static function makeFromResponse(array $request): self
    {
        return new static(
            $request['success']
        );
    }

    public function getSuccess(): bool
    {
        return $this->success;
    }
}
