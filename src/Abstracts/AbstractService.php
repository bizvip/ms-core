<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Abstracts;

use Hyperf\Context\Context;
use Mine\Traits\ServiceTrait;

abstract class AbstractService
{
    use ServiceTrait;

    public $mapper;

    /**
     * 魔术方法，从类属性里获取数据.
     * @param  mixed  $name
     * @return mixed|string
     */
    public function __get($name)
    {
        return $this->getAttributes()[$name] ?? '';
    }

    /**
     * 把数据设置为类属性.
     */
    public function setAttributes(array $data)
    {
        Context::set('attributes', $data);
    }

    /**
     * 获取数据.
     */
    public function getAttributes(): array
    {
        return Context::get('attributes', []);
    }
}
