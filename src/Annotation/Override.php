<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;
use Mine\ServiceException;

#[\Attribute(\Attribute::TARGET_FUNCTION)]
class Override extends AbstractAnnotation
{
    public function collectMethod(string $className, ?string $target): void
    {
        $methodReflect = new \ReflectionMethod($className, $target);
        if (!$methodReflect->isStatic() || !$methodReflect->hasReturnType() || !in_array((string)$methodReflect->getReturnType(), [
                'self',
                $className,
            ])) {
            throw new ServiceException(
                $className.' The override annotation is used on static methods and returns an instance of the current class'
            );
        }

        ComponentCollector::collectOverride($className, [$className, $target]);
    }
}
