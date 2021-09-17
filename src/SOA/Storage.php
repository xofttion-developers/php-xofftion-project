<?php

namespace Xofttion\Project\SOA;

use Illuminate\Database\Eloquent\Collection;
use Xofttion\SOA\Storage as BaseStorage;
use Xofttion\Project\ORM\ModelHidden;

class Storage extends BaseStorage
{

    // Métodos sobrescritos de la clase BaseStorage

    public function resources(): Collection
    {
        if (!$this->isModelHidden()) {
            return $this->getQuery()->catalog();
        }
        else {
            return $this->getQuery()->equal(ModelHidden::DELETED_ROW, false)->catalog();
        }
    }

    // Métodos de la clase Storage

    /**
     * 
     * @return bool
     */
    protected function isModelHidden(): bool
    {
        return in_array(ModelHidden::class , array_keys(class_parents($this->model)));
    }
}
