<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Log\Processor;

use Hyperf\Coroutine\Coroutine;
use Mine\Log\RequestIdHolder;
use Monolog\LogRecord;
use Monolog\Processor\ProcessorInterface;

class SnowflakeRequestIdProcessor implements ProcessorInterface
{
    public function __invoke(array|LogRecord $record)
    {
        RequestIdHolder::setType('snowflake');
        $record['extra']['request_id']   = RequestIdHolder::getId();
        $record['extra']['coroutine_id'] = Coroutine::id();

        return $record;
    }
}
