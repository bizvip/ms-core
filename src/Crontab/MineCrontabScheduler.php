<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Crontab;

class MineCrontabScheduler
{
    /**
     * MineCrontabManage.
     */
    protected MineCrontabManage $crontabManager;

    /**
     * \SplQueue.
     */
    protected \SplQueue $schedules;

    /**
     * MineCrontabScheduler constructor.
     */
    public function __construct(MineCrontabManage $crontabManager)
    {
        $this->schedules      = new \SplQueue();
        $this->crontabManager = $crontabManager;
    }

    public function schedule(): \SplQueue
    {
        foreach ($this->getSchedules() ?? [] as $schedule) {
            $this->schedules->enqueue($schedule);
        }

        return $this->schedules;
    }

    protected function getSchedules(): array
    {
        return $this->crontabManager->getCrontabList();
    }
}
