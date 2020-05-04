<?php

namespace Xofttion\Project;

use Exception;
use Closure;
use Illuminate\Database\QueryException;

use Xofttion\Project\Utils\HttpCode;
use Xofttion\Project\Response;
use Xofttion\Project\Exceptions\ProjectException;

class InteractorUoS {
    use Traits\AuthenticatedTrait;
    use Traits\ResponseTrait;
    use SOA\Traits\UnitOfStorageTrait;
    
    // Constructor de la clase InteractorUoS
    
    public function __construct() {
        
    }
    
    // Métodos de la clase InteractorUoS
    
    /**
     * 
     * @return int
     */
    function getNow(): int {
        return $this->getUnitOfStorage()->getNow();
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
        $this->getUnitOfStorage()->transaction(); // Iniciando
        
        try {
            $response = $callback(); // Ejecutando procesos
            
            $this->getUnitOfStorage()->commit(); // Confirmando
            
            return $response; // Retornando resultado del proceso 
        } catch (Exception $exception) {
            $this->getUnitOfStorage()->rollback(); // Anulando
            
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