<?php

declare(strict_types=1);


namespace Mine\Event;

class UserAdd
{
    public array $userinfo;

    public function __construct(array $userinfo)
    {
        $this->userinfo = $userinfo;
    }
}