<?php

declare(strict_types=1);


namespace Mine\Aspect;

use Hyperf\Context\Context;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Mine\MineModel;
use Mine\MineRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ServerRequestInterface;

use function Hyperf\Config\config;

/**
 * Class UpdateAspect.
 */
#[Aspect]
class UpdateAspect extends AbstractAspect
{
    public array $classes = [
        'Mine\MineModel::update',
    ];

    /**
     * @return mixed
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $instance = $proceedingJoinPoint->getInstance();
        // 更新更改人
        if ($instance instanceof MineModel
            && in_array('updated_by', $instance->getFillable())
            && config('mineadmin.data_scope_enabled')
            && Context::has(ServerRequestInterface::class)
            && container()->get(MineRequest::class)->getHeaderLine('authorization')
        ) {
            try {
                $instance->updated_by = user()->getId();
            } catch (\Throwable $e) {
            }
        }
        return $proceedingJoinPoint->process();
    }
}
