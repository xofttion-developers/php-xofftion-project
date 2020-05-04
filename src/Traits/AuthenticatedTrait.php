<?php

namespace Xofttion\Project\Traits;

use Xofttion\Project\Contracts\IAuthenticated;

trait AuthenticatedTrait {
    
    // Atributos de la clase AuthenticatedTrait
    
    /**
     *
     * @var IAuthenticated 
     */
    private $authenticated = null;
    
    // Métodos del trait AutheticatedTrait
    
    /**
     * 
     * @param IAuthenticated $authenticated
     * @return void
     */
    public function setAuthenticated(IAuthenticated $authenticated): void {
        $this->authenticated = $authenticated;
    }
    
    /**
     * 
     * @return IAuthenticated|null
     */
    public function getAuthenticated(): ?IAuthenticated {
        return $this->authenticated;
    }
    
    /**
     * 
     * @return int|null
     */
    public function getUserId(): ?int {
        return $this->getAuthenticated()->getUserId();
    }
}