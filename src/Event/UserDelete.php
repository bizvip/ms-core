<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Event;

class UserDelete
{
    public array $ids;

    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }
}
