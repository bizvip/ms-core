<?php

declare(strict_types=1);


namespace Mine\Event;

class Operation
{
    protected array $requestInfo;

    public function __construct(array $requestInfo)
    {
        $this->requestInfo = $requestInfo;
    }

    public function getRequestInfo(): array
    {
        return $this->requestInfo;
    }
}
