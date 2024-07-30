<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Interfaces\ServiceInterface;

interface ConfigServiceInterface
{
    /**
     * 按key获取配置，并缓存.
     * @throws \RedisException
     */
    public function getConfigByKey(string $key): ?array;
}
