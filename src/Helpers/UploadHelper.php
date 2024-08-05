<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Helper;

final class UploadHelper
{
    public static function fillStorageDomain(string $url): string
    {
        if ($url !== '' && !str_starts_with($url, 'https')) {
            $url = \config('storage_domain').$url;
        }
        return $url;
    }

    public static function removeStorageDomain(string $url): string
    {
        if ($url === '') {
            return $url;
        }

        if (!str_starts_with($url, 'http')) {
            return $url;
        }

        $storageDomain = \config('storage_domain');
        if (str_contains($url, $storageDomain)) {
            $url = str_replace($storageDomain, '', $url);
        }
        
        return $url;
    }
}