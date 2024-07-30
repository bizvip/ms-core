<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * 依赖代理注解，用于平替某个类.
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class DependProxy extends AbstractAnnotation
{
    public function __construct(public array $values = [], public ?string $provider = null) { }

    public function collectClass(string $className): void
    {
        if (!$this->provider) {
            $this->provider = $className;
        }
        if (count($this->values) == 0 && class_exists($className)) {
            $reflection = new \ReflectionClass($className);
            $interfaces = $reflection->getInterfaces();
            // 按照定义顺序排序接口列表
            uasort($interfaces, function ($a, $b) {
                if (in_array($a->getName(), class_implements($b->getName()))) {
                    return 1;
                }
                if (in_array($b->getName(), class_implements($a->getName()))) {
                    return -1;
                }

                return 0;
            });
            $this->values = [array_values($interfaces)[0]->getName()];
        }
        DependProxyCollector::setAround($className, $this);
    }
}
