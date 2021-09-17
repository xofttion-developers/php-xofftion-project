<?php

namespace Xofttion\Project\SOA\Traits;

use Xofttion\SOA\Contracts\IUnitOfWork;
use Xofttion\SOA\Contracts\IRepository;

trait UnitOfWorkTrait
{

    // Atributos del trait UnitOfWorkTrait

    /**
     *
     * @var IUnitOfWork 
     */
    protected $unitOfWork;

    // Método del trait UnitOfWorkTrait

    /**
     * 
     * @param IUnitOfWork $unitOfWork
     * @return void
     */
    public function setUnitOfWork(IUnitOfWork $unitOfWork): void
    {
        $this->unitOfWork = $unitOfWork;
    }

    /**
     * 
     * @return IUnitOfWork|null
     */
    public function getUnitOfWork(): ?IUnitOfWork
    {
        return $this->unitOfWork;
    }

    /**
     * 
     * @param string $classEntity
     * @return IRepository
     */
    public function getRepository(string $classEntity): IRepository
    {
        return $this->getUnitOfWork()->getRepository($classEntity);
    }

    /**
     * 
     * @return int
     */
    function getNow(): int
    {
        return $this->getUnitOfWork()->getNow();
    }
}
