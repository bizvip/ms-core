<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Annotation;

use Hyperf\Di\MetadataCollector;

class ResourceCollector extends MetadataCollector
{
    protected static array $container = [];

    public static function collectClass(string $className, string $tag)
    {
        static::$container['resource'][$tag] = $className;
    }

    public static function getByCodeService(string $tag)
    {
        $class = static::$container['resource'][$tag] ?? null;
        if (empty($class)) {
            throw new \RuntimeException(sprintf('没有找到%s,或者类[%s]没有实现ResourceService契约', $tag, $class ?? 'null'));
        }

        return container()->get($class);
    }

    public static function list(): array
    {
        return parent::list()['resource'] ?? []; // TODO: Change the autogenerated stub
    }
}
