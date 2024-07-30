<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);
/**
 * This file is part of MineAdmin.
 *
 * @link     https://www.mineadmin.com
 * @document https://doc.mineadmin.com
 * @contact  root@imoi.cn
 * @license  https://github.com/mineadmin/MineAdmin/blob/master/LICENSE
 */

namespace Mine\Generator\Enums;

/**
 * 代码生成类型.
 */
enum GeneratorTypeEnum: string
{
    /**
     * 单表.
     */
    case SINGLE = 'single';

    /**
     * 树表.
     */
    case TREE = 'tree';

    /**
     * 子父表.
     */
    case PARENT_SUB = 'parent_sub';
}
