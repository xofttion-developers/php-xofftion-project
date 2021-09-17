<?php

namespace Xofttion\Project\Interactors\UoW;

use Xofttion\SOA\Contracts\IEntity;
use Xofttion\SOA\Entity;
use Xofttion\Kernel\Contracts\IDataTransfer;
use Xofttion\Project\Response;
use Xofttion\Project\Exceptions\ResourceNotFoundException;

class CrudInteractor extends BaseInteractor
{

    /**
     * 
     * @param IDataTransfer $source
     * @return Response
     */
    public function registrar(IDataTransfer $source): Response
    {
        return $this->controllerTransaction(function () use ($source) {
            $entity = $this->getEntityRegister($source);

            $this->getUnitOfWork()->persist($entity);

            return $this->responseRegisted($this->getResourceName(), $entity);
        });
    }

    /**
     * 
     * @return Response
     */
    public function catalogar(): Response
    {
        return $this->responseSuccess(null, $this->getRepository($this->getEntityClass())->resources());
    }

    /**
     * 
     * @param int $id
     * @return Response
     */
    public function buscar(int $id): Response
    {
        return $this->controllerException(function () use ($id) {
            $entity = $this->getRepository($this->getEntityClass())->fetch($id);

            if (is_null($entity)) {
                throw new ResourceNotFoundException($this->getResourceName());
            }

            return $this->responseSuccess(null, $entity);
        });
    }

    /**
     * 
     * @param int $id
     * @param IDataTransfer $source
     * @return Response
     */
    public function actualizar(int $id, IDataTransfer $source): Response
    {
        return $this->controllerTransaction(function () use ($id, $source) {
            $entity = $this->getEntityUpdate($id, $source);

            $this->getUnitOfWork()->safeguard($entity);

            return $this->responseUpdated($this->getResourceName(), $entity);
        });
    }

    /**
     * 
     * @param int $id
     * @return Response
     */
    public function eliminar(int $id): Response
    {
        return $this->controllerTransaction(function () use ($id) {
            $entity = $this->getRepository($this->getEntityClass())->find($id);

            if (is_null($entity)) {
                throw new ResourceNotFoundException($this->getResourceName());
            }

            $this->getUnitOfWork()->destroy($entity);

            return $this->responseDeleted($this->getResourceName());
        });
    }

    /**
     * 
     * @param IDataTransfer $source
     * @return IEntity
     */
    protected function getEntityRegister(IDataTransfer $source): IEntity
    {
        return $this->setDataRegister($this->mapper($this->getEntityClass(), $source));
    }

    /**
     * 
     * @param IEntity $entity
     * @return IEntity
     */
    protected function setDataRegister(IEntity $entity): IEntity
    {
        return $entity;
    }

    /**
     * 
     * @param int $id
     * @param IDataTransfer $source
     * @return IEntity
     */
    protected function getEntityUpdate(int $id, IDataTransfer $source): IEntity
    {
        $entity = $this->mapper($this->getEntityClass(), $source);

        $entity->setPrimaryKey($id);

        return $this->setDataUpdate($entity);
    }

    /**
     * 
     * @param IEntity $entity
     * @return IEntity
     */
    protected function setDataUpdate(IEntity $entity): IEntity
    {
        return $entity;
    }

    /**
     * 
     * @return string
     */
    protected function getResourceName(): string
    {
        return "Entity";
    }

    /**
     * 
     * @return string   
     */
    protected function getEntityClass(): string
    {
        return Entity::class;
    }
}
