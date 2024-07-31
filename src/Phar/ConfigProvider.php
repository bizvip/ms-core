<?php

declare(strict_types=1);


namespace Hyperf\Phar;

use Hyperf\Framework\Logger\StdoutLogger;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                LoggerInterface::class => StdoutLogger::class,
            ],
            'commands' => [
                BuildCommand::class,
            ],
        ];
    }
}
