<?php

namespace Xofttion\Project\SOA\Traits;

use Xofttion\Kernel\Contracts\IDataTransfer;
use Xofttion\SOA\Contracts\IEntity;
use Xofttion\SOA\Contracts\IEntityMapper;

trait EntityMapperTrait
{

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
    public function setEntityMapper(IEntityMapper $entityMapper): void
    {
        $this->entityMapper = $entityMapper;
    }

    /**
     * 
     * @return IEntityMapper|null
     */
    public function getEntityMapper(): ?IEntityMapper
    {
        return $this->entityMapper;
    }

    /**
     * 
     * @return IEntityMapper|null
     */
    public function cleanEntityMapper(): ?IEntityMapper
    {
        $this->entityMapper->clean();
        
        return $this->entityMapper;
    }

    /**
     * 
     * @param IEntity|string $entity
     * @param IDataTransfer $source
     * @return IEntity
     */
    public function mapper($entity, IDataTransfer $source): IEntity
    {
        $entityMapper = $this->cleanEntityMapper();
        $sourceJson = $source->toArray();
        
        if (!($entity instanceof IEntity)) {
            $instanceEntity = new $entity();
            
            return $entityMapper->ofArray($instanceEntity, $sourceJson);
        }
        else {
            return $entityMapper->ofArray($entity, $sourceJson);
        }
    }
}
