<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * 记录操作日志注解。
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
class OperationLog extends AbstractAnnotation
{
    /**
     * 菜单名称.
     * @var null|string
     */
    public function __construct(public ?string $menuName = null) { }
}
