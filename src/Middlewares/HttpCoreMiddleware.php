<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Middlewares;

use Hyperf\Codec\Json;
use Hyperf\Context\Context;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\CoreMiddleware;
use Mine\Annotation\DependProxy;
use Mine\Helper\MineCode;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

#[DependProxy(values: [CoreMiddleware::class])]
class HttpCoreMiddleware extends CoreMiddleware
{
    /**
     * 跨域
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = Context::get(ResponseInterface::class);
        $response = $response->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS')
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            // Headers 可以根据实际情况进行改写。
            ->withHeader('Access-Control-Allow-Headers', 'accept-language,authorization,lang,uid,token,Keep-Alive,User-Agent,Cache-Control,Content-Type');

        Context::set(ResponseInterface::class, $response);

        if ($request->getMethod() == 'OPTIONS') {
            return $response;
        }

        return parent::process($request, $handler);
    }

    /**
     * Handle the response when cannot found any routes.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function handleNotFound(ServerRequestInterface $request): ResponseInterface
    {
        $format = [
            'success' => false,
            'code'    => MineCode::NOT_FOUND,
            'message' => t('mineadmin.not_found'),
        ];

        return $this->response()->withHeader('Server', 'Admin')
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')->withStatus(404)
            ->withBody(new SwooleStream(Json::encode($format)));
    }

    /**
     * Handle the response when the routes found but doesn't match any available methods.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function handleMethodNotAllowed(array $methods, ServerRequestInterface $request): ResponseInterface
    {
        $format = [
            'success' => false,
            'code'    => MineCode::METHOD_NOT_ALLOW,
            'message' => t('mineadmin.allow_method', ['method' => implode(',', $methods)]),
        ];

        return $this->response()->withHeader('Server', 'Admin')
            ->withAddedHeader('content-type', 'application/json; charset=utf-8')->withStatus(405)
            ->withBody(new SwooleStream(Json::encode($format)));
    }
}
