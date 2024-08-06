<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Helper;

use Carbon\Carbon;
use DateTime;
use Exception;
use Mine\Exception\NormalStatusException;

final class Time
{
    /**
     * 将毫秒级时间戳转换为日期时间字符串，格式为 Y-m-d H:i:s.v
     * @param $millis
     * @return string|null
     */
    public static function millisToYmdHis($millis): ?string
    {
        echo __METHOD__, PHP_EOL;
        print_r($millis);
        echo PHP_EOL;
        if ($millis) {
            return Carbon::createFromTimestampMs($millis)->format('Y-m-d H:i:s.v');
        }
        return null;
    }

    /**
     * 将日期时间字符串转换为毫秒级时间戳
     * @throws Exception
     */
    public static function datetimeToMillis($datetime): ?string
    {
        echo __METHOD__, PHP_EOL;
        print_r($datetime);
        echo PHP_EOL;
        if (empty($datetime)) {
            return null;
        }
        if ($datetime instanceof Carbon) {
            return (string)$datetime->getTimestampMs();
        }
        if (is_string($datetime)) {
            return (string)Carbon::createFromFormat('Y-m-d H:i:s.v', $datetime)->getTimestampMs();
        }
        throw new NormalStatusException('millis 格式不合法');
    }

    /**
     * 获取毫秒时间戳
     * @return string
     */
    public static function getNowMillis(): string
    {
        return (new DateTime())->format('Uv');
    }
}
