<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine;

use Composer\InstalledVersions;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Framework\Bootstrap\ServerStartCallback;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

use function Hyperf\Support\env;

class MineStart extends ServerStartCallback
{
    private StdoutLoggerInterface $stdoutLogger;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function beforeStart(): void
    {
        $console = console();
        $console->info('MineAdmin start success...');
        $console->info($this->welcome());
    }

    protected function welcome(): string
    {
        $projectBasePath = realpath(dirname(InstalledVersions::getInstallPath('bizvip/ms-core'), 2));
        if (env('WELCOME_FILE') && file_exists($projectBasePath.DIRECTORY_SEPARATOR.env('WELCOME_FILE'))) {
            $welcome = file_get_contents(
                $projectBasePath.DIRECTORY_SEPARATOR.env('WELCOME_FILE')
            );
        } else {
            $welcome = '
/---------------------- welcome to use -----------------------\
\________  Copyright WT-Wallet by Archer++ 2024 ~ %s  ______|
';
        }

        return str_replace(['%y',], [date('Y'),], $welcome);
    }
}
