<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Aspect;

use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Mine\Annotation\Transaction;
use Mine\Exception\MineException;

/**
 * Class TransactionAspect.
 */
#[Aspect]
class TransactionAspect extends AbstractAspect
{
    public array $annotations = [
        Transaction::class,
    ];

    /**
     * @return mixed
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        /* @var Transaction $transaction */
        if (isset($proceedingJoinPoint->getAnnotationMetadata()->method[Transaction::class])) {
            $transaction = $proceedingJoinPoint->getAnnotationMetadata()->method[Transaction::class];
        }
        try {
            $connection = $transaction->connection;
            Db::connection($connection)->beginTransaction();
            $number = 0;
            $retry  = intval($transaction->retry);
            do {
                $result = $proceedingJoinPoint->process();
                if (!is_null($result)) {
                    break;
                }
                ++$number;
            } while ($number < $retry);
            Db::connection($connection)->commit();
        } catch (\Throwable $e) {
            Db::connection($connection)->rollBack();
            throw new MineException($e->getMessage(), 500);
        }

        return $result;
    }
}
