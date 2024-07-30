<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Generator\Enums;

/**
 * 组件类型.
 */
enum ComponentTypeEnum: string
{
    /**
     * 模态框.
     */
    case MODAL = 'modal';

    /**
     * 拖拽.
     */
    case DRAWER = 'drawer';

    /**
     * tag.
     */
    case TAG = 'tag';
}
