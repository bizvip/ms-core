<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);


namespace Mine\Event;

class UserLoginAfter
{
    public array $userinfo;

    public bool $loginStatus = true;

    public string $message;

    public string $token;

    public function __construct(array $userinfo)
    {
        $this->userinfo = $userinfo;
    }
}
