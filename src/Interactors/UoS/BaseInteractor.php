<?php

namespace Xofttion\Project\Interactors\UoS;

use Exception;
use Closure;
use Illuminate\Database\QueryException;
use Xofttion\Project\Utils\HttpCode;
use Xofttion\Project\Response;
use Xofttion\Project\Exceptions\ProjectException;

class BaseInteractor
{
    use \Xofttion\Project\Traits\AuthenticatedTrait;
    use \Xofttion\Project\Traits\ResponseTrait;
    use \Xofttion\Project\SOA\Traits\UnitOfStorageTrait;

    // Constructor de la clase BaseInteractor

    public function __construct()
    {

    }

    // Métodos de la clase BaseInteractor

    /**
     * 
     * @return int
     */
    function getNow(): int
    {
        return $this->getUnitOfStorage()->getNow();
    }

    /**
     * 
     * @param Closure $callback
     * @return Response
     */
    protected function controllerException(Closure $callback): Response
    {
        try {
            return $callback();
        }
        catch (Exception $exception) {
            return $this->responseException($exception);
        }
    }

    /**
     * 
     * @param Closure $callback
     * @return Response
     */
    protected function controllerTransaction(Closure $callback): Response
    {
        $this->getUnitOfStorage()->transaction();

        try {
            $response = $callback();

            $this->getUnitOfStorage()->commit();

            return $response;
        }
        catch (Exception $exception) {
            $this->getUnitOfStorage()->rollback();

            return $this->responseException($exception);
        }
    }

    /**
     * 
     * @param Exception $exception
     * @return Response
     */
    private function responseException(Exception $exception): Response
    {
        if ($exception instanceof ProjectException) {
            return new Response(false, $exception->getMessage(), $exception->getHttpCode(), $exception->getAttributes());
        }

        $data = $this->getExceptionData($exception);

        if ($exception instanceof QueryException) {
            $data["sql"] = [
                "code" => $exception->errorInfo[1],
                "info" => $exception->errorInfo
            ];
        }

        return new Response(false, $exception->getMessage(), HttpCode::INTERNAL_SERVER_ERROR, $data);
    }

    /**
     * 
     * @param Exception $exception
     * @return array
     */
    private function getExceptionData(Exception $exception): array
    {
        return [
            "message" => $exception->getMessage(),
            "class" => get_class($exception),
            "exception" => [
                "errorCode" => $exception->getCode(),
                "file" => $exception->getFile(),
                "line" => $exception->getLine(),
                "trace" => $exception->getTrace()
            ]
        ];
    }
}
