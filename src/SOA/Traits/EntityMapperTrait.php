<?php

namespace Xofttion\Project\SOA\Traits;

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
}