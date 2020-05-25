<?php

namespace Xofttion\Project\Exceptions;

use Xofttion\Project\Utils\HttpCode;
use Xofttion\Project\Utils\Messages;

class ResourceNotFoundException extends ProjectException {

    // Constructor de la clase ResourceNotFoundException
    
    public function __construct(string $resource, $data = null) { 
        parent::__construct(Messages::getInstance()->getNotFound($resource), 501); 
        
        $this->setData($data); $this->setHttpCode(HttpCode::NOT_FOUND);
    }
}