<?php

declare(strict_types=1);


namespace Mine\Interfaces\ServiceInterface\Resource;

interface ArrayResource
{
    public function getData(array $params = [], array $extras = []): array;
}
