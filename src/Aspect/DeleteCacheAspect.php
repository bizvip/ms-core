<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Aspect;

use Hyperf\Config\Annotation\Value;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Mine\Annotation\DeleteCache;
use Mine\Helper\Str;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class DeleteCacheAspect.
 */
#[Aspect]
class DeleteCacheAspect extends AbstractAspect
{
    public array $annotations = [
        DeleteCache::class,
    ];

    /**
     * 缓存前缀
     */
    #[Value('cache.default.prefix')]
    protected string $prefix;

    /**
     * @return mixed
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $redis = redis();

        /** @var DeleteCache $deleteCache */
        $deleteCache = $proceedingJoinPoint->getAnnotationMetadata()->method[DeleteCache::class];

        $result = $proceedingJoinPoint->process();

        if (!empty($deleteCache->keys)) {
            $keys     = explode(',', $deleteCache->keys);
            $iterator = null;
            $n        = [];
            foreach ($keys as $key) {
                if (!Str::contains($key, '*')) {
                    $n[] = $this->prefix.$key;
                } else {
                    while (false !== ($k = $redis->scan($iterator, $this->prefix.$key, 100))) {
                        $redis->del($k);
                    }
                }
            }
            $redis->del($n);
        }

        return $result;
    }
}
