<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);


namespace Mine;

use Mine\Traits\ControllerTrait;

/**
 * 后台控制器基类
 * Class MineController.
 */
abstract class MineController
{
    use ControllerTrait;

    public function __construct(
        readonly protected Mine $mine,
        readonly protected MineRequest $request,
        readonly protected MineResponse $response
    ) {}

    public function getResponse(): MineResponse
    {
        return $this->response;
    }

    public function getRequest(): MineRequest
    {
        return $this->request;
    }
}
