<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Helper;

use Carbon\Carbon;

final class TimeHelper
{
    // 将毫秒级时间戳转换为日期时间字符串，格式为 Y-m-d H:i:s.u
    public static function convertMillisToDatetime(int|string $millis): ?string
    {
        if ($millis) {
            $seconds = (int)$millis / 1000;
            return Carbon::createFromTimestamp($seconds)->format('Y-m-d H:i:s.u');
        }
        return null;
    }

    // 将日期时间字符串转换为毫秒级时间戳
    public static function convertDatetimeToMillis(string $datetime): ?int
    {
        if ($datetime) {
            return (int)(Carbon::parse($datetime)->format('Uv'));
        }
        return null;
    }
}
