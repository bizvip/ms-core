<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

#[\Attribute(\Attribute::TARGET_FUNCTION | \Attribute::IS_REPEATABLE)]
class PostConstruct extends AbstractAnnotation
{
    public function __construct(public int $order = 0) { }

    public function collectMethod(string $className, ?string $target): void
    {
        ComponentCollector::collectPostConstruct($className, $this->order, [
            $className,
            $target,
        ]);
    }
}
