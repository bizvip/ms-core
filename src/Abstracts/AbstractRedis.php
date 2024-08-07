<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Abstracts;

use Hyperf\Redis\Redis;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractRedis.
 */
abstract class AbstractRedis
{
    protected string $prefix;

    /**
     * key 类型名.
     */
    protected string $typeName;

    /**
     * redis实例.
     */
    protected Redis $redis;

    /**
     * 日志实例.
     */
    protected LoggerInterface $logger;

    public function __construct(Redis $redis, LoggerInterface $logger)
    {
        $this->redis  = $redis;
        $this->logger = $logger;
        $this->prefix = \Hyperf\Config\config('cache.default.prefix');
    }

    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public function getRedis(): Redis
    {
        return $this->redis;
    }

    /**
     * 获取redis实例.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function redis(): Redis
    {
        return $this->getRedis();
    }

    /**
     * 获取key.
     */
    public function getKey(string $key): ?string
    {
        return empty($key) ? null : ($this->prefix.trim($this->typeName, ':').':'.$key);
    }
}
