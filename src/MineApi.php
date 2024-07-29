<?php

declare(strict_types=1);


namespace Mine;

use Mine\Traits\ControllerTrait;

/**
 * API接口控制器基类
 * Class MineApi.
 */
abstract class MineApi
{
    use ControllerTrait;

    public function __construct(
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
