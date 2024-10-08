<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine;

use Hyperf\Command\Command as HyperfCommand;

/**
 * Class MineCommand.
 */
abstract class MineCommand extends HyperfCommand
{
    protected const CONSOLE_GREEN_BEGIN = "\033[32;5;1m";

    protected const CONSOLE_RED_BEGIN = "\033[31;5;1m";

    protected const CONSOLE_END = "\033[0m";

    protected string $module;

    protected function getGreenText($text): string
    {
        return self::CONSOLE_GREEN_BEGIN.$text.self::CONSOLE_END;
    }

    protected function getRedText($text): string
    {
        return self::CONSOLE_RED_BEGIN.$text.self::CONSOLE_END;
    }

    protected function getStub($filename): string
    {
        return BASE_PATH.'/vendor/bizvip/ms-core/src/Command/Creater/Stubs/'.$filename.'.stub';
    }

    protected function getModulePath(): string
    {
        return BASE_PATH.'/app/'.$this->module.'/Request/';
    }

    protected function getInfo(): string
    {
        return sprintf('/---------------------- welcome to use -----------------------');
    }
}
