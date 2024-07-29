<?php

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
