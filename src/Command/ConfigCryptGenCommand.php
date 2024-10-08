<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Command;

use Hyperf\Command\Annotation\Command;
use Mine\MineCommand;

/**
 * Class JwtCommand.
 */
#[Command]
class ConfigCryptGenCommand extends MineCommand
{
    /**
     * 生成key和向量.
     */
    protected ?string $name = 'mine:config-crypt-gen';

    public function configure()
    {
        parent::configure();
        $this->setHelp('run "php bin/run mine:config-crypt-gen" create the key and iv for config encrypt');
        $this->setDescription('MineAdmin system gen config crypt key and iv command');
    }

    /**
     * @throws \Throwable
     */
    public function handle()
    {
        $key = base64_encode(random_bytes(32));
        $iv  = base64_encode(random_bytes(openssl_cipher_iv_length('AES-128-CBC')));

        $this->info('config encrypt key generator successfully:'.$key);
        $this->info('config encrypt iv generator successfully:'.$iv);
    }
}
