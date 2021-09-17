<?php

namespace Xofttion\Project\SOA;

use Xofttion\SOA\Contracts\IEntityCollection;
use Xofttion\SOA\Repository as BaseRepository;
use Xofttion\Project\ORM\ModelHidden;
use Xofttion\Project\SOA\EntityHidden;

class Repository extends BaseRepository
{

    // Métodos sobrescritos de la clase BaseRepository

    public function resources(): IEntityCollection
    {
        $entity = $this->getEntity();
        $query = $this->getQuery($entity);

        if ($entity instanceof EntityHidden) {
            $query->equal(ModelHidden::DELETED_ROW, false);
        }

        return $this->createCollection($query->catalog());
    }
}
