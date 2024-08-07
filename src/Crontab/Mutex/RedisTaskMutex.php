<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Crontab\Mutex;

use Hyperf\Redis\RedisFactory;
use Mine\Crontab\MineCrontab;

class RedisTaskMutex implements TaskMutex
{
    /**
     * @var RedisFactory
     */
    private $redisFactory;

    public function __construct(RedisFactory $redisFactory)
    {
        $this->redisFactory = $redisFactory;
    }

    /**
     * Attempt to obtain a task mutex for the given crontab.
     */
    public function create(MineCrontab $crontab): bool
    {
        return (bool)$this->redisFactory->get($crontab->getMutexPool())->set(
            $this->getMutexName($crontab), $crontab->getName(), [
                'NX',
                'EX' => $crontab->getMutexExpires(),
            ]
        );
    }

    /**
     * Determine if a task mutex exists for the given crontab.
     */
    public function exists(MineCrontab $crontab): bool
    {
        return (bool)$this->redisFactory->get($crontab->getMutexPool())->exists(
            $this->getMutexName($crontab)
        );
    }

    /**
     * Clear the task mutex for the given crontab.
     */
    public function remove(MineCrontab $crontab)
    {
        $this->redisFactory->get($crontab->getMutexPool())->del(
            $this->getMutexName($crontab)
        );
    }

    protected function getMutexName(MineCrontab $crontab): string
    {
        return 'framework'.DIRECTORY_SEPARATOR.'crontab-'.sha1($crontab->getName().$crontab->getRule());
    }
}
