<?php

namespace Xofttion\Project\Exceptions;

use Exception;

use Xofttion\Project\Utils\HttpCode;

class ProjectException extends Exception {
    
    // Atributos de la clase ProjectException

    /**
     *
     * @var object 
     */
    protected $data;

    /**
     *
     * @var int
     */
    protected $appcode;
    
    /**
     *
     * @var int 
     */
    protected $httpcode;

    // Constructor de la clase ApplicationException
    
    public function __construct(string $message) {
        parent::__construct($message); // Constructor padre
        
        $this->httpcode = HttpCode::INTERNAL_SERVER_ERROR;
    }
    
    // Métodos de la clase ApplicationException
    
    /**
     * 
     * @param mixed $data
     * @return void
     */
    public function setData($data): void {
        $this->data = $data;
    }
    
    /**
     * 
     * @return mixed
     */
    public function getData() {
        return $this->data;
    }

    /**
     * 
     * @return int
     */
    public function getAppCode(): int {
        return $this->appcode;
    }
    
    /**
     * 
     * @return int
     */
    public function getHttpCode(): int {
        return $this->httpcode;
    }

    /**
     * 
     * @return array
     */
    public function getAttributes(): array {
        return [
            "message"   => $this->getMessage(),
            "data"      => $this->getData(),
            "code"      => $this->getAppCode(),
            "class"     => get_class($this),
            "exception" => [
                "code"  => $this->getCode(),
                "file"  => $this->getFile(),
                "line"  => $this->getLine(),
                "trace" => $this->getTrace()
            ]
        ];
    }
}