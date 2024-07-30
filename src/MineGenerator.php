<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Generator;

use Composer\InstalledVersions;
use Psr\Container\ContainerInterface;

abstract class MineGenerator
{
    public const NO = 1;

    public const YES = 2;

    protected string $stubDir;

    protected string $namespace;

    /**
     * MineGenerator constructor.
     */
    public function __construct(protected ContainerInterface $container)
    {
        $this->setStubDir(
            realpath(
                InstalledVersions::getInstallPath(
                    'xmo/mine-generator'
                )
            ).DIRECTORY_SEPARATOR.'Stubs'.DIRECTORY_SEPARATOR
        );
    }

    public function getStubDir(): string
    {
        return $this->stubDir;
    }

    public function setStubDir(string $stubDir)
    {
        $this->stubDir = $stubDir;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param  mixed  $namespace
     */
    public function setNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
    }

    public function replace(): self
    {
        return $this;
    }
}
