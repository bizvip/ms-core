<?php

declare(strict_types=1);

use Hyperf\Config\Config;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Mine\Aspect\ConfigCryptAspect;

beforeEach(function () {
    $this->configEnable = new Config([
        'mineadmin' => [
            'config_encryption' => true,
            'config_encryption_key' => 'N1pQLQd8qkTDvb//iOwZ5uGvpBusW6PsNwbKUXroXKE=',
            'config_encryption_iv' => 'ZmGep5xz4oFCfDrzzHJ26Q==',
        ],
        'test' => [
            'key1' => 'ENC(qJhrnXpKmxZJC2MxNoTAbg==)',
        ],
    ]);
    $this->configDisable = new Config([
        'mineadmin' => [
            'config_encryption' => false,
        ],
        'test' => [
            'key1' => 'ENC(6SX9TNnNO7KH+WFTOmVOFZ2jGsbR4K/0M0BwXvxtu34=)',
        ],
    ]);
});

test(ConfigCryptAspect::class . ' testing', function () {
    // enable
    $proceedingJoinPoint = Mockery::mock(ProceedingJoinPoint::class);
    $proceedingJoinPoint->allows('process')->andreturn($this->configEnable);
    $configCryptAspect = new ConfigCryptAspect();
    $config = $configCryptAspect->process($proceedingJoinPoint);
    expect($config !== $this->configEnable)
        ->toBeFalse()
        ->and($config->get('test.key1'))
        ->toEqual('1234');

    // disable

    $proceedingJoinPoint = Mockery::mock(ProceedingJoinPoint::class);
    $proceedingJoinPoint->allows('process')->andreturn($this->configDisable);
    $configCryptAspect = new ConfigCryptAspect();
    $config = $configCryptAspect->process($proceedingJoinPoint);
    expect($config)->toEqual($this->configDisable);
});
