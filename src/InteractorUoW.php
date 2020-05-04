<?php

namespace Xofttion\Project;

use Exception;
use Closure;
use Illuminate\Database\QueryException;

use Xofttion\Kernel\Contracts\IDataTransfer;

use Xofttion\SOA\Contracts\IEntity;

use Xofttion\Project\Utils\HttpCode;
use Xofttion\Project\Response;
use Xofttion\Project\Exceptions\ProjectException;

class InteractorUoW {
    use Traits\AuthenticatedTrait;
    use Traits\ResponseTrait;
    use SOA\Traits\UnitOfWorkTrait;
    use SOA\Traits\EntityMapperTrait;
    
    // Constructor de la clase InteractorUoW
    
    public function __construct() {
        
    }
    
    // Métodos de la clase InteractorUoW
    
    /**
     * 
     * @return int
     */
    function getNow(): int {
        return $this->getUnitOfWork()->getNow();
    }

    /**
     * 
     * @param IEntity|string $entity
     * @param IDataTransfer $source
     * @return IEntity
     */
    public function mapper($entity, IDataTransfer $source): IEntity {
        if (!($entity instanceof IEntity)) {
            return $this->cleanEntityMapper()->ofArray(new $entity(), $source->toArray());
        } else {
            return $this->cleanEntityMapper()->ofArray($entity, $source->toArray());
        }
    }

    /**
     * 
     * @param Closure $callback
     * @return Response
     */
    protected function controllerException(Closure $callback): Response {
        try {
            return $callback();
        } catch (Exception $exception) {
            return $this->responseException($exception);
        }
    }

    /**
     * 
     * @param Closure $callback
     * @return Response
     */
    protected function controllerTransaction(Closure $callback): Response {
        $this->getUnitOfWork()->setMapper($this->getEntityMapper());
        
        $this->getUnitOfWork()->transaction(); // Iniciando
        
        try {
            $response = $callback(); // Ejecutando procesos
            
            $this->getUnitOfWork()->commit(); // Confirmando
            
            return $response; // Retornando resultado del proceso 
        } catch (Exception $exception) {
            $this->getUnitOfWork()->rollback(); // Anulando
            
            return $this->responseException($exception); // Excepción
        }
    }
    
    /**
     * 
     * @param Exception $exception
     * @return Response
     */
    private function responseException(Exception $exception): Response {
        if ($exception instanceof ProjectException) {
            return new Response(false, $exception->getMessage(), $exception->getHttpCode(), $exception->getAttributes());
        } // La excepción fue generada por lógica de la aplicación

        $data = $this->getExceptionData($exception); // Excepción

        if ($exception instanceof QueryException) {
            $data["sql"] = [
                "code" => $exception->errorInfo[1], 
                "info" => $exception->errorInfo
            ];
        } // Se generó una excepción respecto a la base de datos

        return new Response(false, $exception->getMessage(), HttpCode::INTERNAL_SERVER_ERROR, $data);
    }

    /**
     * 
     * @param Exception $exception
     * @return array
     */
    private function getExceptionData(Exception $exception): array {
        return [
            "message"   => $exception->getMessage(),
            "class"     => get_class($exception),
            "exception" => [
                "errorCode" => $exception->getCode(),
                "file"      => $exception->getFile(),
                "line"      => $exception->getLine(),
                "trace"     => $exception->getTrace()
            ]
        ];
    }
}