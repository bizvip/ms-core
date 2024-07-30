<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Middlewares;

use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\Di\Annotation\Inject;
use Mine\Exception\NormalStatusException;
use Mine\Helper\Str;
use Mine\Interfaces\ServiceInterface\ModuleServiceInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 检查模块.
 */
class CheckModuleMiddleware implements MiddlewareInterface
{
    /**
     * 模块服务
     */
    #[Inject]
    protected ModuleServiceInterface $service;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $uri = $request->getUri();

        if ($uri->getPath() !== '/favicon.ico' && mb_substr_count($uri->getPath(), '/') > 1) {
            [$empty, $moduleName, $controllerName] = explode('/', $uri->getPath());

            $path = $moduleName.'/'.$controllerName;

            $moduleName = Str::lower($moduleName);

            $module['enabled'] = false;

            foreach ($this->service->getModuleCache() as $name => $item) {
                if (Str::lower($name) === $moduleName) {
                    $module = $item;
                    break;
                }
            }

            $annotation = AnnotationCollector::getClassesByAnnotation('Hyperf\HttpServer\Annotation\Controller');

            foreach ($annotation as $item) {
                if ($item->server === 'http' && $item->prefix === $path && !$module['enabled']) {
                    throw new NormalStatusException('模块被禁用', 500);
                }
            }
        }

        return $handler->handle($request);
    }
}
