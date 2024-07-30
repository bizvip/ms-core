<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Event;

use Psr\Http\Message\ResponseInterface;

class ApiAfter
{
    protected ?array $apiData;

    protected ResponseInterface $result;

    public function __construct(?array $apiData, ResponseInterface $result)
    {
        $this->apiData = $apiData;
        $this->result  = $result;
    }

    public function getApiData(): ?array
    {
        return $this->apiData;
    }

    public function getResult(): ResponseInterface
    {
        return $this->result;
    }
}
