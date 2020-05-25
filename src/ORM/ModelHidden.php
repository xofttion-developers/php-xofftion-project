<?php

namespace Xofttion\Project\ORM;

class ModelHidden extends Model {
    
    // Constantes de clase ModelHidden
    
    const DELETED_ROW  = "registro_eliminado";
    
    const DELETED_USER = "usuario_id_eliminacion";
    
    const DELETED_AT   = "fechahora_eliminacion";
    
    // Métodos sobrescritos de la clase Model
    
    protected function getConversionsDefault(): array {
        return [
            self::CREATED_AT => "datetime",
            self::UPDATED_AT => "datetime",
            self::DELETED_AT => "datetime"
        ];
    }
}