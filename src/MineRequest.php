<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Request;

class MineRequest extends Request
{
    /**
     * MineResponse.
     */
    #[Inject]
    protected MineResponse $response;

    /**
     * 获取请求IP.
     */
    public function ip(): string
    {
        $ip      = $this->getServerParams()['remote_addr'] ?? '0.0.0.0';
        $headers = $this->getHeaders();

        if (isset($headers['x-real-ip'])) {
            $ip = $headers['x-real-ip'][0];
        } elseif (isset($headers['x-forwarded-for'])) {
            $ip = $headers['x-forwarded-for'][0];
        } elseif (isset($headers['http_x_forwarded_for'])) {
            $ip = $headers['http_x_forwarded_for'][0];
        }

        return $ip;
    }

    /**
     * 获取协议架构.
     */
    public function getScheme(): string
    {
        if (isset($this->getHeader('X-scheme')[0])) {
            return $this->getHeader('X-scheme')[0].'://';
        }

        return 'http://';
    }
}
