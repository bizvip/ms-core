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
use Mine\MineModel;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

use function Hyperf\Config\config;

/**
 * Class SaveAspect.
 */
#[Aspect]
class SaveAspect extends AbstractAspect
{
    public array $classes = [
        'Mine\MineModel::save',
    ];

    /**
     * @return mixed
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws \Exception
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint): mixed
    {
        /** @var MineModel $instance */
        $instance = $proceedingJoinPoint->getInstance();

        if (config('mineadmin.data_scope_enabled')) {
            try {
                $user = user();
                // 设置创建人
                if ($instance instanceof MineModel && in_array($instance->getDataScopeField(), $instance->getFillable()) && is_null($instance[$instance->getDataScopeField()])) {
                    $user->check();
                    $instance[$instance->getDataScopeField()] = $user->getId();
                }

                // 设置更新人
                if ($instance instanceof MineModel && in_array('updated_by', $instance->getFillable())) {
                    $user->check();
                    $instance->updated_by = $user->getId();
                }
            } catch (\Throwable $e) {
            }
        }
        // 生成雪花ID 或者 UUID
        if ($instance instanceof MineModel && !$instance->incrementing && empty($instance->{$instance->getKeyName()})) {
            $instance->setPrimaryKeyValue($instance->getPrimaryKeyType() === 'int' ? snowflake_id() : uuid());
        }

        return $proceedingJoinPoint->process();
    }
}
