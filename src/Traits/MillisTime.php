<?php

declare(strict_types=1);

namespace Mine\Traits;

use Carbon\Carbon;

trait MillisTime
{
    // 毫秒时间戳部分开始==============================

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

    // ==============================毫秒时间戳部分结束
}
