<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Factory;

use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Contract\ContainerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class DependProxyFactory
{
    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public static function define(string $name, string $definition, bool $isLogger = true): void
    {
        /** @var ContainerInterface $container */
        $container = ApplicationContext::getContainer();
        $config    = $container->get(ConfigInterface::class);

        if (\interface_exists($definition) || \class_exists($definition)) {
            $config->set("dependencies.{$name}", $definition);
            $container->define($name, $definition);
        }
        if (\interface_exists($name)) {
            $config->set("mineadmin.dependProxy.{$name}", $definition);
        }

        if ($container->has($name)) {
            $isLogger && logger()->info(
                sprintf('Dependencies [%s] Injection to the [%s] successfully.', $definition, $name)
            );
        } else {
            $isLogger && logger()->warning(sprintf('Dependencies [%s] Injection to the [%s] failed.', $definition, $name));
        }
    }
}
