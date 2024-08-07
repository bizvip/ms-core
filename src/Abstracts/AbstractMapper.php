<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Abstracts;

use Hyperf\Context\Context;
use Mine\MillisModel;
use Mine\MineModel;
use Mine\Traits\MapperTrait;

/**
 * Class AbstractMapper.
 */
abstract class AbstractMapper
{
    use MapperTrait;

    /**
     * @var class-string|MineModel|MillisModel
     */
    public $model;

    public function __construct()
    {
        $this->assignModel();
    }

    /**
     * 魔术方法，从类属性里获取数据.
     * @return mixed|string
     */
    public function __get(string $name)
    {
        return $this->getAttributes()[$name] ?? '';
    }

    /**
     * 魔术方法，设置类属性.
     * @param  string  $name
     * @param  mixed  $value
     */
    public function __set(string $name, mixed $value): void
    {
        throw new \BadMethodCallException("__set method not allowed");
    }

    /**
     * 魔术方法，检查属性是否存在.
     */
    public function __isset(string $name): bool
    {
        return isset($this->getAttributes()[$name]);
    }

    abstract public function assignModel();

    /**
     * 把数据设置为类属性.
     */
    public static function setAttributes(array $data): void
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
