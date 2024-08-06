<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Helper;

final class Time
{
    /**
     * 将毫秒级时间戳转换为日期时间字符串，格式为 Y-m-d H:i:s
     * @param $millis
     * @return string|null
     */
    public static function millisToYmdHis($millis): ?string
    {
        if ($millis) {
            $dt = new \DateTime();
            $dt->setTimestamp((int)($millis / 1000));
            // $microSeconds = sprintf("%06d", $millis % 1000 * 1000);
            // return $dt->format('Y-m-d H:i:s').'.'.$microSeconds;
            return $dt->format('Y-m-d H:i:s');
        }
        return null;
    }

    /**
     * 将日期时间字符串转换为毫秒级时间戳
     * @throws \Exception
     */
    public static function datetimeToMillis($datetime): ?int
    {
        if ($datetime) {
            $dt = new \DateTime($datetime);
            return (int)($dt->format('U') * 1000) + (int)$dt->format('v');
        }
        return null;
    }

    // 获取毫秒时间戳
    public static function getMillis(): int
    {
        return (int)((new \DateTime())->format('U.v'));
    }
}