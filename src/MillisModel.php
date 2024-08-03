<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine;

use Hyperf\DbConnection\Model\Model;
use Hyperf\ModelCache\Cacheable;
use Mine\Helper\TimeHelper;
use Mine\Traits\ModelMacroTrait;

/**
 * 自定义毫秒时间戳基类模型
 */
class MillisModel extends Model
{
    use Cacheable;
    use ModelMacroTrait;

    // ==============================毫秒时间戳开始==============================

    public bool $timestamps = false;      // 开关自动管理时间戳（created_at 和 updated_at）
    protected ?string $dateFormat = 'Uv'; // 设置数据库存储数据格式为13位毫秒时间戳

    public function getCreatedAtAttribute($value): ?string
    {
        return TimeHelper::convertMillisToDatetime($value);
    }

    public function getUpdatedAtAttribute($value): ?string
    {
        return TimeHelper::convertMillisToDatetime($value);
    }

    public function getDeletedAtAttribute($value): ?string
    {
        return TimeHelper::convertMillisToDatetime($value);
    }

    public function setCreatedAtAttribute($value): void
    {
        $this->attributes['created_at'] = TimeHelper::convertDatetimeToMillis($value);
    }

    public function setUpdatedAtAttribute($value): void
    {
        $this->attributes['updated_at'] = TimeHelper::convertDatetimeToMillis($value);
    }

    public function setDeletedAtAttribute($value): void
    {
        $this->attributes['deleted_at'] = TimeHelper::convertDatetimeToMillis($value);
    }

    // ==============================毫秒时间戳结束==============================

    public const ENABLE    = 1;
    public const DISABLE   = 2;
    public const PAGE_SIZE = 10;

    /**
     * 隐藏的字段列表.
     * @var string[]
     */
    protected array $hidden = ['deleted_at'];

    // 数据权限字段，表中需要有此字段.
    protected string $dataScopeField = 'created_by';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        // 注册常用方法
        $this->registerBase();
        // 注册用户数据权限方法
        $this->registerUserDataScope();
    }

    // 设置主键的值
    public function setPrimaryKeyValue(int|string $value): void
    {
        $this->{$this->primaryKey} = $value;
    }

    public function getPrimaryKeyType(): string
    {
        return $this->keyType;
    }

    public function save(array $options = []): bool
    {
        return parent::save($options);
    }

    public function update(array $attributes = [], array $options = []): bool
    {
        return parent::update($attributes, $options);
    }

    public function newCollection(array $models = []): MineCollection
    {
        return new MineCollection($models);
    }

    public function getDataScopeField(): string
    {
        return $this->dataScopeField;
    }

    public function setDataScopeField(string $name): self
    {
        $this->dataScopeField = $name;
        return $this;
    }
}
