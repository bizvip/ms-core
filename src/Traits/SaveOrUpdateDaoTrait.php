<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Traits;

use Hyperf\Collection\Arr;
use Hyperf\Collection\Collection;
use Hyperf\Database\Model\Model;
use Hyperf\DbConnection\Db;
use Mine\Abstracts\BaseDao;
use Mine\Contract\SaveOrUpdateDaoContract;

/**
 * @mixin BaseDao
 * @implements SaveOrUpdateDaoContract
 */
trait SaveOrUpdateDaoTrait
{
    public function saveOrUpdate(array $data, ?array $where = null): Model
    {
        $keyName = $this->getModelInstance()->getKeyName();
        if ($where === null) {
            return $this->getModel()::updateOrCreate(
                Arr::only($data, [$keyName]), $data
            );
        }

        return $this->getModelQuery()->updateOrCreate($where, $data);
    }

    public function batchSaveOrUpdate(array $data, ?array $whereKeys = null, int $batchSize = 0): Collection
    {
        return Db::transaction(function () use ($data, $whereKeys) {
            $result = [];
            foreach ($data as $item) {
                if ($whereKeys === null) {
                    $result[] = $this->saveOrUpdate(
                        $item
                    );
                } else {
                    $result[] = $this->saveOrUpdate(
                        $item, Arr::only($item, $whereKeys)
                    );
                }
            }

            return Collection::make($result);
        });
    }
}
