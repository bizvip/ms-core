<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Annotation;

use Hyperf\Di\MetadataCollector;

class ComponentCollector extends MetadataCollector
{
    protected static array $container = [
        'component'     => [],
        'postConstruct' => [],
        'override'      => [],
    ];

    public static function collectComponent(string $class): void
    {
        static::$container['component'] = $class;
    }

    public static function collectPostConstruct(string $class, int $order, $initialStaticCall): void
    {
        static::$container['postConstruct'][$class][$order] = $initialStaticCall;
    }

    public static function collectOverride(string $class, $override): void
    {
        static::$container['override'][$class] = $override;
    }

    public static function getComponent(?string $component = null): null|array|string
    {
        if ($component) {
            return static::$container['component'][$component] ?? null;
        }

        return static::$container['component'];
    }

    public static function getPostConstruct(?string $component = null): null|array|string
    {
        if ($component) {
            return static::$container['postConstruct'][$component] ?? null;
        }

        return static::$container['postConstruct'];
    }

    public static function getOverride(?string $component = null): null|array|string
    {
        if ($component) {
            return static::$container['override'][$component] ?? null;
        }

        return static::$container['override'];
    }
}
