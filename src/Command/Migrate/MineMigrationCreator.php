<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Command\Migrate;

use Hyperf\Database\Migrations\MigrationCreator;

class MineMigrationCreator extends MigrationCreator
{
    public function stubPath(): string
    {
        return BASE_PATH.'/vendor/bizvip/ms-core/src/Command/Migrate/Stubs';
    }
}
