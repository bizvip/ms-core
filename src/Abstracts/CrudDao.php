<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Abstracts;

use Mine\Contract\DeleteDaoContract;
use Mine\Contract\PageDaoContract;
use Mine\Contract\SaveOrUpdateDaoContract;
use Mine\Contract\UpdateDaoContract;
use Mine\Traits\DeleteDaoTrait;
use Mine\Traits\SaveOrUpdateDaoTrait;
use Mine\Traits\SelectDaoTrait;
use Mine\Traits\UpdateDaoTrait;

/**
 * CrudService.
 * @template T
 * @implements PageDaoContract<T>
 * @implements SaveOrUpdateDaoContract<T>
 */
abstract class CrudDao extends BaseDao implements PageDaoContract, UpdateDaoContract,
                                                  SaveOrUpdateDaoContract, DeleteDaoContract
{
    use UpdateDaoTrait;
    use SaveOrUpdateDaoTrait;
    use DeleteDaoTrait;
    use SelectDaoTrait;
}
