<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);


namespace Mine\Interfaces\ServiceInterface\Resource;

use Hyperf\Database\Model\Builder;

interface QueryResource
{
    /**
     * 获取Query.
     */
    public function getQuery(): Builder;

    /**
     * 处理请求
     */
    public function handleSearch(Builder $query, array $params = [], array $extras = []): Builder;
}
