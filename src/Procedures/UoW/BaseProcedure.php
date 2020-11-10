<?php

namespace Xofttion\Project\Procedures\UoW;

class BaseProcedure {
    use \Xofttion\Project\Traits\AuthenticatedTrait;
    use \Xofttion\Project\SOA\Traits\UnitOfWorkTrait;
    use \Xofttion\Project\SOA\Traits\EntityMapperTrait;
    
    // Constructor de la clase BaseInteractor
    
    public function __construct() {
        
    }
}