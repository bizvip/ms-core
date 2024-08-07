<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Traits;

use Hyperf\DbConnection\Db;
use Hyperf\DbConnection\Model\Model;
use Mine\Abstracts\BaseDao;
use Mine\Contract\DeleteDaoContract;

/**
 * @mixin BaseDao
 * @implements DeleteDaoContract
 */
trait DeleteDaoTrait
{
    public function remove(mixed $idOrWhere, bool $force = false): bool
    {
        return Db::transaction(function () use ($idOrWhere, $force) {
            $modelClass = $this->getModel();
            $query      = $modelClass::query();
            /**
             * @var null|bool|Model $instance
             */
            $instance = false;
            if (is_array($idOrWhere)) {
                $instance = $query->where($idOrWhere)->first();
            }
            if (is_callable($idOrWhere)) {
                $instance = $query->where($idOrWhere)->first();
            }
            if ($instance === false) {
                $instance = $query->find($idOrWhere);
            }
            if (empty($instance)) {
                return false;
            }
            if ($force) {
                return $instance->forceDelete();
            }

            return false;
        });
    }

    public function delete(mixed $id): bool
    {
        $model   = $this->getModel();
        $query   = $model::query()->getModel();
        $keyName = $query->getModel()->getKeyName();
        /**
         * @var null|Model $instance
         */
        $instance = false;
        if (is_array($id)) {
            $instance = $query->where($id)->first();
        }
        if (is_callable($id)) {
            $instance = $query->where($id)->first();
        }
        if ($instance === null) {
            $instance = $query->find($id);
        }
        if (empty($instance)) {
            return false;
        }

        return $model::query()->where(
            $keyName, $instance->getKey()
        )->delete();
    }

    public function removeByIds(array $ids): bool
    {
        $query   = $this->getModelQuery();
        $keyName = $query->getModel()->getKeyName();

        return $query->whereIn($keyName, $ids)->delete();
    }
}
