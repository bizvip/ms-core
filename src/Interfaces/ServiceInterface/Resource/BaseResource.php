<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Interfaces\ServiceInterface\Resource;

/**
 * 基础资源Service.
 */
interface BaseResource
{
    public function resource(array $params = [], array $extras = []): array;
}
