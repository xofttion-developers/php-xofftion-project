<?php

namespace Xofttion\Project\SOA\Traits;

use Xofttion\SOA\Contracts\IUnitOfStorage;
use Xofttion\SOA\Contracts\IStorage;

trait UnitOfStorageTrait {
    
    // Atributos del trait UnitOfStorageTrait
    
    /**
     *
     * @var IUnitOfStorage 
     */
    protected $unitOfStorage;
    
    // Método del trait UnitOfStorageTrait
    
    /**
     * 
     * @param IUnitOfStorage $unitOfStorage
     * @return void
     */
    public function setUnitOfStorage(IUnitOfStorage $unitOfStorage): void {
        $this->unitOfStorage = $unitOfStorage;
    }
    
    /**
     * 
     * @return IUnitOfStorage|null
     */
    public function getUnitOfStorage(): ?IUnitOfStorage {
        return $this->unitOfStorage;
    }
    
    /**
     * 
     * @param string $classModel
     * @return IStorage
     */
    public function getStorage(string $classModel): IStorage {
        return $this->getUnitOfStorage()->getStorage($classModel);
    }
}