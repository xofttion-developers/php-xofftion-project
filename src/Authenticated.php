<?php

namespace Xofttion\Project;

use Xofttion\Kernel\Contracts\IJson;
use Xofttion\Kernel\Structs\Json;

use Xofttion\Project\Contracts\IAuthenticated;

class Authenticated implements IAuthenticated {
    
    // Atributos de la clase Authenticated
    
    /**
     *
     * @var IAuthenticated 
     */
    private static $instance = null;
    
    // Atributos de la clase Authenticated
    
    /**
     *
     * @var IJson 
     */
    protected $resources;

    // Constantes de la clase Authenticated
    
    protected const USER_ID = "user_id";

    // Constructor de la clase Authenticated
    
    private function __construct() {
        
    }
    
    // Métodos de la clase Authenticated

    /**
     * 
     * @return Authenticated
     */
    public static function getInstance(): IAuthenticated {
        if (is_null(self::$instance)) {
            self::$instance = new static(); // Instanciando Authenticated
        } 
        
        return self::$instance; // Retornando Authenticated
    }

    /**
     * 
     * @return IJson|null
     */
    protected function getDictionary(): ?IJson {
        return $this->resources;
    }
    
    // Métodos sobrescritos de la interfaz IAuthenticated
    
    public function exists(): bool {
        return !is_null($this->resources);
    }
    
    public function start(): void {
        if (!$this->exists()) { 
            $this->resources = new Json(); // Instanciando
        }
    }
    
    public function destroy(): void {
        $this->resources = null;
    }
    
    public function attach(string $key, $value): void {
        if ($this->exists()) { 
            $this->getDictionary()->attach($key, $value);
        }
    }

    public function contains(string $key): bool {
        return (!$this->exists()) ? false : $this->getDictionary()->contains($key);
    }
    
    public function detach(string $key): void {
        if ($this->exists()) { 
            $this->getDictionary()->detach($key);
        }
    }
    
    public function getValue(string $key) {
        return (!$this->exists()) ? null : $this->getDictionary()->getValue($key); 
    }

    public function attachUserId(int $id): void {
        $this->attach(static::USER_ID, $id);
    }
    
    public function getUserId(): ?int {
        return $this->getValue(static::USER_ID);
    }
}