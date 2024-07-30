<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

#[\Attribute(\Attribute::TARGET_CLASS)]
class Resource extends AbstractAnnotation
{
    public function __construct(public string $tag) { }

    public function collectClass(string $className): void
    {
        ResourceCollector::collectClass($className, $this->tag);
    }
}
