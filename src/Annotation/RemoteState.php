<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * 设置某个万能通用接口状态，true 允许使用，false 禁止使用.
 */
#[\Attribute(\Attribute::TARGET_METHOD)]
class RemoteState extends AbstractAnnotation
{
    /**
     * @param  bool  $state  状态
     */
    public function __construct(public bool $state = true) { }
}
