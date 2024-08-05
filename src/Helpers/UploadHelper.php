<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Helper;

final class UploadHelper
{
    public static function fillUrl(string $url): string
    {
        if ($url !== '' && !str_starts_with($url, 'https')) {
            $url = \config('storage_domain').$url;
        }
        return $url;
    }
}