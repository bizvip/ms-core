<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Crontab;

use Carbon\Carbon;
use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Swoole\Coroutine;

use function Hyperf\Coroutine\co;

class MineCrontabStrategy
{
    /**
     * MineCrontabManage.
     */
    #[Inject]
    protected MineCrontabManage $mineCrontabManage;

    /**
     * MineExecutor.
     */
    #[Inject]
    protected MineExecutor $executor;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function dispatch(MineCrontab $crontab)
    {
        co(function () use ($crontab) {
            if ($crontab->getExecuteTime() instanceof Carbon) {
                $wait = $crontab->getExecuteTime()->getTimestamp() - time();
                $wait > 0 && Coroutine::sleep($wait);
                $this->executor->execute($crontab);
            }
        });
    }

    /**
     * 执行一次
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function executeOnce(MineCrontab $crontab)
    {
        co(function () use ($crontab) {
            $this->executor->execute($crontab);
        });
    }
}
