<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine;

use Mine\Annotation\ComponentCollector;
use Mine\Annotation\DependProxyCollector;
use Mine\Listener\DependProxyListener;

class ServiceConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [],
            'commands'     => [],
            'listeners'    => [
                DependProxyListener::class => PHP_INT_MAX,
            ],
            // 合并到  config/autoload/annotations.php 文件
            'annotations'  => [
                'scan' => [
                    'paths'      => [
                        __DIR__,
                    ],
                    'collectors' => [
                        DependProxyCollector::class,
                        ComponentCollector::class,
                    ],
                ],
            ],
        ];
    }
}
