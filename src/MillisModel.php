<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine;

use Carbon\Carbon;
use Hyperf\DbConnection\Model\Model;
use Hyperf\ModelCache\Cacheable;
use Mine\Traits\ModelMacroTrait;

/**
 * 自定义毫秒时间戳基类模型
 */
class MillisModel extends Model
{
    use Cacheable;
    use ModelMacroTrait;

    // ==============================毫秒时间戳==============================
    public bool $timestamps = false;     // 关闭自动管理时间戳（created_at 和 updated_at）
    protected ?string $dateFormat = 'Uv';// 设置数据库存储数据格式为13位毫秒时间戳

    public function getCreatedAtAttribute($value): ?string
    {
        return $this->convertMillisToDatetime($value);
    }

    public function getUpdatedAtAttribute($value): ?string
    {
        return $this->convertMillisToDatetime($value);
    }

    public function getDeletedAtAttribute($value): ?string
    {
        return $this->convertMillisToDatetime($value);
    }

    public function setCreatedAtAttribute($value): void
    {
        $this->attributes['created_at'] = $this->convertDatetimeToMillis($value);
    }

    public function setUpdatedAtAttribute($value): void
    {
        $this->attributes['updated_at'] = $this->convertDatetimeToMillis($value);
    }

    public function setDeletedAtAttribute($value): void
    {
        $this->attributes['deleted_at'] = $this->convertDatetimeToMillis($value);
    }

    // 将毫秒级时间戳转换为日期时间字符串，格式为 Y-m-d H:i:s.u
    protected function convertMillisToDatetime($millis): ?string
    {
        if ($millis) {
            $seconds = $millis / 1000;

            return Carbon::createFromTimestamp($seconds)->format('Y-m-d H:i:s.u');
        }

        return null;
    }

    // 将日期时间字符串转换为毫秒级时间戳
    protected function convertDatetimeToMillis($datetime): ?int
    {
        if ($datetime) {
            return (int)(Carbon::parse($datetime)->format('Uv'));
        }

        return null;
    }

    // ==============================毫秒时间戳==============================

    /**
     * 状态
     */
    public const ENABLE = 1;
    public const DISABLE = 2;

    /**
     * 默认每页记录数.
     */
    public const PAGE_SIZE = 15;

    /**
     * 隐藏的字段列表.
     * @var string[]
     */
    protected array $hidden = ['deleted_at'];

    /**
     * 数据权限字段，表中需要有此字段.
     */
    protected string $dataScopeField = 'created_by';

    /**
     * MineModel constructor.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        // 注册常用方法
        $this->registerBase();
        // 注册用户数据权限方法
        $this->registerUserDataScope();
    }

    /**
     * 设置主键的值
     * @param  int|string  $value
     */
    public function setPrimaryKeyValue($value): void
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
