<?php

namespace Xofttion\Project\ORM;

use Xofttion\ORM\Contracts\IModelMapper;
use Xofttion\ORM\Model as BaseModel;

use Xofttion\Project\ORM\Utils\ModelMapper;

class Model extends BaseModel {
    
    // Constantes de clase Model
    
    const PRIMARY_KEY  = "id";
    
    const CREATED_USER = "usuario_id_registro";
    
    const CREATED_AT   = "fechahora_registro";
    
    const UPDATED_USER = "usuario_id_actualizacion";
    
    const UPDATED_AT   = "fechahora_actualizacion";
    
    // Métodos sobrescritos de la clase BaseModel
    
    protected function getConversionsDefault(): array {
        return [
            self::CREATED_AT => "datetime",
            self::UPDATED_AT => "datetime"
        ];
    }
    
    public function getMapper(): IModelMapper {
        return ModelMapper::getInstance();
    }
}