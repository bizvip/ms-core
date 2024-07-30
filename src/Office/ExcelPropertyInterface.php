<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Office;

use Mine\MineModel;
use Psr\Http\Message\ResponseInterface;

interface ExcelPropertyInterface
{
    public function import(MineModel $model, ?\Closure $closure = null): mixed;

    public function export(string $filename, array|\Closure $closure): ResponseInterface;
}
