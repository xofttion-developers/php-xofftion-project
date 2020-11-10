<?php

namespace Xofttion\Project\SOA\Traits;

use Xofttion\Kernel\Contracts\IDataTransfer;

use Xofttion\SOA\Contracts\IEntity;
use Xofttion\SOA\Contracts\IEntityMapper;

trait EntityMapperTrait {
    
    // Atributos del trait EntityMapperTrait
    
    /**
     *
     * @var IEntityMapper 
     */
    private $entityMapper;
    
    // Métodos del trait EntityMapperTrait
    
    /**
     * 
     * @param IEntityMapper $entityMapper
     * @return void
     */
    public function setEntityMapper(IEntityMapper $entityMapper): void {
        $this->entityMapper = $entityMapper;
    }
    
    /**
     * 
     * @return IEntityMapper|null
     */
    public function getEntityMapper(): ?IEntityMapper {
        return $this->entityMapper;
    }
    
    /**
     * 
     * @return IEntityMapper|null
     */
    public function cleanEntityMapper(): ?IEntityMapper {
        $this->entityMapper->clean(); return $this->getEntityMapper();
    }

    /**
     * 
     * @param IEntity|string $entity
     * @param IDataTransfer $sourceJson
     * @return IEntity
     */
    public function mapper($entity, IDataTransfer $sourceJson): IEntity {
        if (!($entity instanceof IEntity)) {
            return $this->cleanEntityMapper()->ofArray(new $entity(), $sourceJson->toArray());
        } else {
            return $this->cleanEntityMapper()->ofArray($entity, $sourceJson->toArray());
        }
    }
}