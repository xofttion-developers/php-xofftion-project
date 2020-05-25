<?php

namespace Xofttion\Project\Exceptions;

use Exception;

use Xofttion\Project\Utils\HttpCode;

class ProjectException extends Exception {
    
    // Atributos de la clase ApplicationException

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

    /**
     *
     * @var object 
     */
    protected $data;

    // Constructor de la clase ApplicationException
    
    public function __construct(string $message, ?int $appcode = null) {
        parent::__construct($message); // Constructor padre
        
        $this->setAppCode($appcode);
        $this->setHttpCode(HttpCode::INTERNAL_SERVER_ERROR);
    }
    
    // Métodos de la clase ApplicationException
    
    /**
     * 
     * @param int|null $code
     * @return void
     */
    protected function setAppCode(?int $code): void {
        $this->appcode = $code;
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
     * @param int $code
     * @return void
     */
    protected function setHttpCode(int $code): void {
        $this->httpcode = $code;
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
     * @param object $data
     * @return void
     */
    public function setData($data): void {
        $this->data = $data;
    }
    
    /**
     * 
     * @return object
     */
    public function getData() {
        return $this->data;
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