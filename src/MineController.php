<?php

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
