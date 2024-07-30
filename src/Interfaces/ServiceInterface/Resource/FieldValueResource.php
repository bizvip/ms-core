<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);


namespace Mine\Interfaces\ServiceInterface\Resource;

interface FieldValueResource
{
    /**
     * 获取select field.
     */
    public function getField(): string;

    /**
     * 获取select value.
     */
    public function getValue(): string;
}
