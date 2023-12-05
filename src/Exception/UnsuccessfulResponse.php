<?php

declare(strict_types=1);

namespace OneSignal\Exception;

use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class UnsuccessfulResponse extends Exception implements OneSignalExceptionInterface
{
    protected RequestInterface $request;

    protected ResponseInterface $response;

    public function __construct(RequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;

        parent::__construct();
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
