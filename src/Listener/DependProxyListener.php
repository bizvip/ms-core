<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Listener;

use Hyperf\Contract\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Framework\Event\BootApplication;
use Mine\Annotation\ComponentCollector;
use Mine\Annotation\DependProxyCollector;

class DependProxyListener implements ListenerInterface
{
    public function __construct(public ContainerInterface $container) { }

    public function listen(): array
    {
        return [BootApplication::class];
    }

    public function process(object $event): void
    {
        $this->handleComponent();
        $this->handleDefined();
    }

    private function handleComponent(): void
    {
        $components     = ComponentCollector::getComponent();
        $postConstructs = ComponentCollector::getPostConstruct();
        $overrides      = ComponentCollector::getOverride();
        $container      = $this->container;
        foreach ($components as $component) {
            if (!empty($overrides[$component])) {
                $container->define($component, ($overrides[$component])(...));
            } else {
                $componentInstance = $container->make($component);
                if (!empty($postConstructs[$component])) {
                    $constructs = $postConstructs[$component];
                    rsort($constructs, SORT_DESC);
                    foreach ($constructs as $construct) {
                        $componentInstance->{$construct}();
                    }
                }
            }
        }
    }

    private function handleDefined(): void
    {
        foreach (DependProxyCollector::list() as $collector) {
            $targets    = $collector->values;
            $definition = $collector->provider;
            foreach ($targets as $target) {
                $this->container->define($target, $definition);
            }
        }
    }
}
