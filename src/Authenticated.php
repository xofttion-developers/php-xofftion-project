<?php

namespace Xofttion\Project;

use Xofttion\Project\Contracts\IAuthenticated;

use Xofttion\Kernel\Structs\DataDictionary;

class Authenticated implements IAuthenticated {
    
    // Atributos de la clase Authenticated
    
    /**
     *
     * @var Authenticated 
     */
    private static $instance = null;
    
    // Constantes de la clase Authenticated
    
    protected const KEY     = "xofttion";
    
    protected const USER_ID = "user_id";

    // Constructor de la clase Authenticated
    
    private function __construct() {
        
    }
    
    // Métodos de la clase Authenticated

    /**
     * 
     * @return Authenticated
     */
    public static function getInstance(): Authenticated {
        if (is_null(self::$instance)) {
            self::$instance = new static(); // Instanciando Authenticated
        } 
        
        return self::$instance; // Retornando Authenticated
    }

    /**
     * 
     * @return DataDictionary
     */
    private function getDictionary(): DataDictionary {
        return $_SESSION[static::KEY];
    }
    
    // Métodos sobrescritos de la interfaz IAuthenticated
    
    public function exists(): bool {
        return isset($_SESSION[static::KEY]);
    }
    
    public function start(): void {
        if (!$this->exists()) { 
            $_SESSION[static::KEY] = new DataDictionary(); // Instanciando sesión
        }
    }
    
    public function destroy(): void {
        unset($_SESSION[static::KEY]); session_destroy(); 
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
    
    public function getKey(): string {
       return static::KEY; 
    }
}