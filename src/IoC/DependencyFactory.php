<?php

namespace Xofttion\Project\IoC;

use Xofttion\IoC\Contracts\IDependencyFactory;
use Xofttion\IoC\ClassInstance;
use Xofttion\SOA\StoreEntity;
use Xofttion\SOA\StoreRepository;
use Xofttion\SOA\StoreModel;
use Xofttion\SOA\StoreStorage;
use Xofttion\Project\Authenticated;
use Xofttion\Project\SOA\MySqlUnitOfWork;
use Xofttion\Project\SOA\MySqlUnitOfStorage;
use Xofttion\Project\SOA\Utils\EntityMapper;

class DependencyFactory implements IDependencyFactory
{

    // Métodos de la clase DependencyFactory

    /**
     * 
     * @param string $class
     * @return ClassInstance
     */
    protected function forAuthenticated(string $class): ClassInstance
    {
        return (new ClassInstance($class))->attach("authenticated", Authenticated::class , true);
    }

    /**
     * 
     * @param string $class
     * @param bool $isMapper
     * @return ClassInstance
     */
    protected function forMySqlTransaction(string $class, bool $isMapper = false): ClassInstance
    {
        $instance = $this->forAuthenticated($class)->attach("unitOfWork", MySqlUnitOfWork::class , true);

        if (!$isMapper) {
            return $instance;
        }
        else {
            return $instance->attach("entityMapper", EntityMapper::class);
        }
    }

    /**
     * 
     * @param string $class
     * @return ClassInstance
     */
    protected function forMySqlStorage(string $class): ClassInstance
    {
        return $this->forAuthenticated($class)->attach("unitOfStorage", MySqlUnitOfStorage::class , true);
    }

    // Métodos sobrescritos de la interfaz IDependencyFactory

    public function build(string $class)
    {
        switch ($class) {
            case (Authenticated::class): {
                return Authenticated::getInstance();
            }

            case (EntityMapper::class): {
                return EntityMapper::getInstance();
            }

            case (MySqlUnitOfWork::class): {
                $mysqlWork = new MySqlUnitOfWork();
                $mysqlWork->setContext("mysql");
                $mysqlWork->setStoreRepository(new StoreRepository());
                $mysqlWork->setStoreEntity(new StoreEntity());

                return $mysqlWork;
            }

            case (MySqlUnitOfStorage::class): {
                $mysqlStorage = new MySqlUnitOfStorage();
                $mysqlStorage->setContext("mysql");
                $mysqlStorage->setStoreStorage(new StoreStorage());
                $mysqlStorage->setStoreModel(new StoreModel());

                return $mysqlStorage;
            }

            default: {
                return new $class();
            }
        }
    }
}
