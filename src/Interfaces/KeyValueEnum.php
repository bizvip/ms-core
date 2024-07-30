<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Interfaces;

/**
 * key/value 枚举接口.
 */
interface KeyValueEnum
{
    public function key();

    public function value();
}
