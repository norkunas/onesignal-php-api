<?php

declare(strict_types=1);

namespace OneSignal\Exception;

use Exception;

class UnsuccessfulResponse extends Exception implements OneSignalExceptionInterface
{
    protected array $response;

    public function __construct(array $response)
    {
        $this->response = $response;

        parent::__construct();
    }

    public function getResponse(): array
    {
        return $this->response;
    }
}
