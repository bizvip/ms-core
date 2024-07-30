<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);


namespace Mine\Annotation\Api\Enums;

enum MApiAuthModeEnum: int
{
    /**
     * 简单模式.
     */
    case EASY = 1;

    /**
     * 复杂模式.
     */
    case NORMAL = 2;
}
