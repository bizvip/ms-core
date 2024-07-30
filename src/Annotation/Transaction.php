<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * 数据库事务注解。
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
class Transaction extends AbstractAnnotation
{
    /**
     * @param  int  $retry  重试次数
     */
    public function __construct(public int $retry = 1, public ?string $connection = null) { }
}
