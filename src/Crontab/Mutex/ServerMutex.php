<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Crontab\Mutex;

use Mine\Crontab\MineCrontab;

interface ServerMutex
{
    /**
     * Attempt to obtain a server mutex for the given crontab.
     */
    public function attempt(MineCrontab $crontab): bool;

    /**
     * Get the server mutex for the given crontab.
     */
    public function get(MineCrontab $crontab): string;
}
