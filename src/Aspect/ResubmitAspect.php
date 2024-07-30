<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Redis\Redis;
use Mine\Annotation\Resubmit;
use Mine\Exception\NormalStatusException;
use Mine\MineRequest;
use Mine\Redis\MineLockRedis;

use function Hyperf\Support\make;

/**
 * Class ResubmitAspect.
 */
#[Aspect]
class ResubmitAspect extends AbstractAspect
{
    public array $annotations = [
        Resubmit::class,
    ];

    /**
     * @return mixed
     * @throws Exception
     * @throws \Throwable
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        /* @var $resubmit Resubmit */
        if (isset($proceedingJoinPoint->getAnnotationMetadata()->method[Resubmit::class])) {
            $resubmit = $proceedingJoinPoint->getAnnotationMetadata()->method[Resubmit::class];
        }

        $request = container()->get(MineRequest::class);

        $key = md5(sprintf('%s-%s-%s', $request->ip(), $request->getPathInfo(), $request->getMethod()));

        $lockRedis = new MineLockRedis(
            make(Redis::class), make(LoggerFactory::class)->get('Mine Redis Lock')
        );
        $lockRedis->setTypeName('resubmit');

        if ($lockRedis->check($key)) {
            $lockRedis = null;
            throw new NormalStatusException($resubmit->message ?: t('mineadmin.resubmit'), 500);
        }

        $lockRedis->lock($key, $resubmit->second);
        $lockRedis = null;

        return $proceedingJoinPoint->process();
    }
}
