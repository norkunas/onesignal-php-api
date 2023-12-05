<?php

declare(strict_types=1);

namespace OneSignal\Exception;

use Exception;

class UnsuccessfulResponse extends Exception implements OneSignalExceptionInterface
{
    protected array $request;

    public function __construct(array $request)
    {
        $this->request = $request;

        parent::__construct();
    }

    public function getRequest(): array
    {
        return $this->request;
    }
}
