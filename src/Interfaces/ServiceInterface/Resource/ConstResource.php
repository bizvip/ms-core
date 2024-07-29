<?php

declare(strict_types=1);


namespace Mine\Interfaces\ServiceInterface\Resource;

interface ConstResource
{
    public function getConst(array $params = [], array $extras = []): string;
}
