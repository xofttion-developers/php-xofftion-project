<?php

namespace Xofttion\Project\Utils;

class Messages {
    
    // Atributos de la clase Messages
    
    /**
     *
     * @var Messages 
     */
    private static $instance = null;
    
    // Constructor de la clase Messages
    
    private function __construct() {
        
    }

    /**
     * 
     * @return Messages
     */
    public static function getInstance(): Messages {
        if (is_null(self::$instance)) {
            self::$instance = new static(); // Instanciando Messages
        } 
        
        return self::$instance; // Retornando Messages
    }
    
    // Métodos de la clase Messages
    
    /**
     * 
     * @param string $resource
     * @return string
     */
    public function getRegisted(string $resource): string {
        return "$resource ha sido registrado (a) correctamente en la Plataforma";
    }
    
    /**
     * 
     * @param string $resource
     * @return string
     */
    public function getNotFound(string $resource): string {
        return "$resource solicitado (a) no ha sido encontrado en la Plataforma";
    }
    
    /**
     * 
     * @param string $resource
     * @return string
     */
    public function getUpdated(string $resource): string {
        return "$resource ha sido actualizado (a) correctamente en la Plataforma";
    }
    
    /**
     * 
     * @param string $resource
     * @return string
     */
    public function getDeleted(string $resource): string {
        return "$resource ha sido eliminado (a) correctamente de la Plataforma";
    }
    
    /**
     * 
     * @param string $resource
     * @return string
     */
    public function getAttached(string $resource): string {
        return "$resource ha sido agregado (a) correctamente en la Plataforma";
    }
    
    /**
     * 
     * @param string $resource
     * @param bool $status
     * @return string
     */
    public function getToggleStatus(string $resource, bool $status): string {
        return "$resource fue ".($status ? "reactivado (a)" : "inactivado (a)")." para realizar funciones en la Plataforma";
    }
}