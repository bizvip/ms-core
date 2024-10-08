<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Crontab\Mutex;

use Mine\Crontab\MineCrontab;

interface TaskMutex
{
    /**
     * Attempt to obtain a task mutex for the given crontab.
     */
    public function create(MineCrontab $crontab): bool;

    /**
     * Determine if a task mutex exists for the given crontab.
     */
    public function exists(MineCrontab $crontab): bool;

    /**
     * Clear the task mutex for the given crontab.
     */
    public function remove(MineCrontab $crontab);
}
