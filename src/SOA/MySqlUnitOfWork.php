<?php

namespace Xofttion\Project\SOA;

use Illuminate\Database\QueryException;
use Xofttion\SOA\Contracts\IEntity;
use Xofttion\SOA\UnitOfWork;
use Xofttion\SOA\StatusEntity;
use Xofttion\Project\Authenticated;
use Xofttion\Project\ORM\Utils\MySqlCode;
use Xofttion\Project\SOA\Entity;
use Xofttion\Project\SOA\EntityHidden;

class MySqlUnitOfWork extends UnitOfWork
{

    // Métodos sobrescritos de la clase UnitOfWork

    protected function insert(IEntity $entity): void
    {
        if ($entity instanceof Entity) {
            $entity->setUsuarioIdRegistro(Authenticated::getInstance()->getUserId());
            $entity->setFechaHoraRegistro($this->getNow());
        }

        parent::insert($entity);
    }

    protected function modify(IEntity $entity): void
    {
        if ($entity instanceof Entity) {
            $entity->setUsuarioIdActualizacion(Authenticated::getInstance()->getUserId());
            $entity->setFechaHoraActualizacion($this->getNow());
        }

        parent::modify($entity);
    }

    protected function update(IEntity $entity, StatusEntity $status): void
    {
        if ($status->getEntity() != $entity) {
            if ($entity instanceof Entity) {
                $entity->setUsuarioIdActualizacion(Authenticated::getInstance()->getUserId());
                $entity->setFechaHoraActualizacion($this->getNow());
            }

            $data = $this->getArrayUpdate($entity, $status->getEntity());

            $repository = $this->getRepository(get_class($entity));

            $repository->update($entity->getPrimaryKey(), $data);
        }
    }

    protected function delete(IEntity $entity): void
    {
        try {
            parent::delete($entity);
        }
        catch (QueryException $ex) {
            if (($ex->errorInfo[1] == MySqlCode::FK_CONSTRAINS_PARENT)) {
                $this->hidden($ex, $entity);
            }
            else {
                throw $ex;
            }
        }
    }

    // Métodos de la clase MySqlUnitOfWork

    /**
     * 
     * @param QueryException $ex
     * @param IEntity $entity
     */
    private function hidden(QueryException $ex, IEntity $entity)
    {
        if ($entity instanceof EntityHidden) {
            $entity->setUsuarioIdEliminacion(Authenticated::getInstance()->getUserId());
            $entity->setRegistroEliminado(true);
            $entity->setFechaHoraEliminacion($this->getNow());

            $repository = $this->getRepository(get_class($entity));

            $repository->safeguard($entity);
        }
        else {
            throw $ex;
        }
    }
}
