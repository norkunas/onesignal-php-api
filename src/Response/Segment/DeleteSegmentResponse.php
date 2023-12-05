<?php

declare(strict_types=1);

namespace OneSignal\Response\Segment;

use OneSignal\Exception\UnsuccessfulResponse;
use OneSignal\Response\AbstractResponse;

final class DeleteSegmentResponse implements AbstractResponse
{
    protected bool $success;

    public function __construct(bool $success)
    {
        $this->success = $success;
    }

    public static function makeFromRequest(array $request): self
    {
        if (!$request['success']) {
            throw new UnsuccessfulResponse($request);
        }

        return new static(
            $request['success']
        );
    }

    public function getSuccess(): bool
    {
        return $this->success;
    }
}
