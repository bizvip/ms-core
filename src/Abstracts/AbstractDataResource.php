<?php
/******************************************************************************
 * Copyright (c) 2024. Archer++. All rights reserved.                         *
 * Author ORCID: https://orcid.org/0009-0003-8150-367X                        *
 ******************************************************************************/

declare(strict_types=1);

namespace Mine\Abstracts;

use Hyperf\Constants\ConstantsCollector;
use Mine\Interfaces\ServiceInterface\Resource\ArrayResource;
use Mine\Interfaces\ServiceInterface\Resource\ConstResource;
use Mine\Interfaces\ServiceInterface\Resource\DataResource;

abstract class AbstractDataResource implements DataResource
{
    public function data(array $params = [], array $extras = []): array
    {
        // 如果是array则直接返回
        if ($this instanceof ArrayResource) {
            return $this->getData($params, $extras);
        }

        // 如果是Enums则先解析结果再返回
        if ($this instanceof ConstResource) {
            $const = ConstantsCollector::get($this->getConst($params, $extras));
            $data  = [];
            foreach ($const as $value => $item) {
                $data[$item['message']] = $value;
            }

            return $data;
        }

        return [];
    }

    public function resource(array $params = [], array $extras = []): array
    {
        $data     = $this->data($params, $extras);
        $resource = [];
        foreach ($data as $field => $value) {
            $resource[] = compact('field', 'value');
        }

        return $resource;
    }
}
