<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Exception\Handler;

use Hyperf\Codec\Json;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Mine\Exception\TokenException;
use Mine\Helper\MineCode;
use Mine\Log\RequestIdHolder;
use Mine\MineRequest;
use Psr\Http\Message\ResponseInterface;

/**
 * Class TokenExceptionHandler.
 */
class TokenExceptionHandler extends ExceptionHandler
{
    public function handle(\Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        $this->stopPropagation();
        $format = [
            'requestId' => RequestIdHolder::getId(),
            'path'      => container()->get(MineRequest::class)->getUri()->getPath(),
            'success'   => false,
            'message'   => $throwable->getMessage(),
            'code'      => MineCode::TOKEN_EXPIRED,
        ];

        return $response->withHeader('Server', 'Admin')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Headers', 'accept-language,authorization,lang,uid,token,Keep-Alive,User-Agent,Cache-Control,Content-Type')
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')->withStatus(401)
            ->withBody(new SwooleStream(Json::encode($format)));
    }

    public function isValid(\Throwable $throwable): bool
    {
        return $throwable instanceof TokenException;
    }
}
