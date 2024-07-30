<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Generator\Enums;

/**
 * 执行输出生成类型.
 */
enum GenerateTypeEnum: int
{
    /**
     * 压缩包.
     */
    case ZIP = 1;

    /**
     * 生成到模块.
     */
    case OUTPUT_MODULE = 2;
}
