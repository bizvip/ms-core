<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Helper;

final class Hash
{
    public static function fileSha256(string $filepath): string
    {
        $file = fopen($filepath, 'rb');
        if (!$file) {
            throw new \RuntimeException("sha256 file open failed");
        }
        $context = hash_init('sha256');
        while (!feof($file)) {
            $buffer = fread($file, 8192);
            hash_update($context, $buffer);
        }
        $hash = hash_final($context);
        fclose($file);
        return $hash;
    }
}
