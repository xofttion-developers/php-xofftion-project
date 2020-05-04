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

class MySqlUnitOfWork extends UnitOfWork {
    
    // Métodos sobrescritos de la clase BaseUnitOfWork

    protected function insert(IEntity $entity): void {
        if ($entity instanceof Entity) {
            $entity->setUsuarioIdRegistro(Authenticated::getInstance()->getUserId());
            $entity->setFechaHoraRegistro($this->getNow()); // Fecha/Hora
        } // Se debe agregar los datos sobre registro
        
        parent::insert($entity); // Insertando de manera predeterminada
    }
    
    protected function modify(IEntity $entity): void  {
        if ($entity instanceof Entity) {
            $entity->setUsuarioIdActualizacion(Authenticated::getInstance()->getUserId());
            $entity->setFechaHoraActualizacion($this->getNow()); // Fecha/Hora
        } // Se debe agregar los datos sobre modificación
        
        parent::modify($entity); // Modificando de manera predeterminada
    }
    
    protected function update(IEntity $entity, StatusEntity $status): void {
        if ($status->getEntity() != $entity) {
            if ($entity instanceof Entity) {
                $entity->setUsuarioIdActualizacion(Authenticated::getInstance()->getUserId());
                $entity->setFechaHoraActualizacion($this->getNow()); // Fecha/Hora
            } // Se debe agregar los datos sobre modificación
            
            $data = $this->getArrayUpdate($entity, $status->getEntity());

            $this->getRepository(get_class($entity))->update($entity->getPrimaryKey(), $data);
        } // Entidad modificada, requiere ser actualizada en el Repositorio
    }
    
    protected function delete(IEntity $entity): void {
        try {
            parent::delete($entity); // Eliminando de manera predeterminada
        } catch (QueryException $ex) {
            if (($ex->errorInfo[1] == MySqlCode::FK_CONSTRAINS_PARENT)) {
                $this->hidden($ex, $entity);
            } else {
                throw $ex; // Relanzando la excepción generada
            }
        }
    }

    // Métodos de la clase MySqlUnitOfWork
    
    /**
     * 
     * @param QueryException $ex
     * @param IEntity $entity
     */
    private function hidden(QueryException $ex, IEntity $entity) {
        if ($entity instanceof EntityHidden) {
            $entity->setUsuarioIdEliminacion(Authenticated::getInstance()->getUserId());
            $entity->setRegistroEliminado(true);
            $entity->setFechaHoraEliminacion($this->getNow()); // Fecha/Hora
            
            $this->getRepository(get_class($entity))->safeguard($entity);
        } else {
            throw $ex; // Relanzando la excepción generada
        }
    }
}