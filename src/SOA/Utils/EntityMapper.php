<?php

namespace Xofttion\Project\SOA\Utils;

use Xofttion\SOA\Contracts\IEntity;
use Xofttion\SOA\Utils\EntityMapper as BaseEntityMapper;
use Xofttion\Kernel\Contracts\IDataTransfer;

class EntityMapper extends BaseEntityMapper
{

    // Métodos sobrescritos de la clase BaseEntityMapper

    protected function createEntity(string $classEntity, $value): ?IEntity
    {
        if ($value instanceof IDataTransfer) {
            return $this->ofArray(new $classEntity(), $value->toArray());
        }

        return parent::createEntity($classEntity, $value);
    }
}
