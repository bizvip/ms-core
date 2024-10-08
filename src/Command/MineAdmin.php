<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Command;

use Hyperf\Command\Annotation\Command;
use Mine\MineCommand;

/**
 * Class MineAdmin.
 */
#[Command]
class MineAdmin extends MineCommand
{
    protected ?string $name = 'mine';

    public function configure()
    {
        parent::configure(); // TODO: Change the autogenerated stub
    }

    /**
     * Handle the current command.
     */
    public function handle()
    {
        $result = shell_exec('php '.BASE_PATH.'/bin/run | grep mine');
        $this->line($this->getInfo(), 'comment');
        $this->line(preg_replace('/\s+mine\s+/', '', $result), 'info');
    }
}
