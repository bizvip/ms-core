<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Command;

use Hyperf\Command\Annotation\Command;
use Mine\MineCommand;
use Symfony\Component\Console\Input\InputArgument;

use function Hyperf\Config\config;

/**
 * Class JwtCommand.
 */
#[Command]
class ConfigCryptCommand extends MineCommand
{
    /**
     * 生成JWT密钥命令.
     */
    protected ?string $name = 'mine:config-crypt';

    public function configure()
    {
        parent::configure();
        $this->setHelp('run "php bin/run mine:config-crypt" encrypt');
        $this->setDescription('system config crypt command');
    }

    /**
     * @throws \Throwable
     */
    public function handle()
    {
        $value = $this->input->getArgument('value');
        $key   = config('mineadmin.config_encryption_key', '');
        if (empty($key)) {
            $this->line('Not found mineadmin.config_encryption_key config.', 'error');

            return self::FAILURE;
        }

        $key = @base64_decode($key);
        if (empty($key)) {
            $this->line('key content error.', 'error');

            return self::FAILURE;
        }

        $iv = config('mineadmin.config_encryption_iv', '');
        if (empty($iv)) {
            $this->line('Not found mineadmin.config_encryption_iv config.', 'error');

            return self::FAILURE;
        }

        $iv = @base64_decode($iv);
        if (empty($iv)) {
            $this->line('iv content error.', 'error');

            return self::FAILURE;
        }

        $encrypt = @openssl_encrypt($value, 'AES-128-CBC', $key, 0, $iv);

        if (empty($encrypt)) {
            $this->line('iv or key content error.please regen', 'error');

            return self::FAILURE;
        }

        $this->info('config crypt string is: ENC('.$encrypt.')');
    }

    protected function getArguments()
    {
        return [
            ['value', InputArgument::REQUIRED, 'source value'],
        ];
    }
}
