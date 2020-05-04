<?php

namespace Xofttion\Project\SOA;

class EntityHidden extends Entity {
    
    // Atributos de la clase EntityHidden
    
    /**
     *
     * @var bool 
     */
    protected $registro_eliminado;

    /**
     *
     * @var int 
     */
    protected $usuario_id_eliminacion;
    
    /**
     *
     * @var int 
     */
    protected $fechahora_eliminacion;

    // Métodos de la clase EntityHidden
    
    /**
     * 
     * @param bool $registroEliminado
     */
    public function setRegistroEliminado(?bool $registroEliminado) {
        $this->registro_eliminado = $registroEliminado;
    }
    
    /**
     * 
     * @return bool
     */
    public function isRegistroEliminado(): ?bool {
        return $this->registro_eliminado;
    }

    /**
     * 
     * @param int $usuarioIdEliminacion
     */
    public function setUsuarioIdEliminacion(?int $usuarioIdEliminacion) {
        $this->usuario_id_eliminacion = $usuarioIdEliminacion;
    }
    
    /**
     * 
     * @return int
     */
    public function getUsuarioIdEliminacion(): ?int {
       return $this->usuario_id_eliminacion; 
    }
    
    /**
     * 
     * @param int $fechaHoraEliminacion
     */
    public function setFechaHoraEliminacion(?int $fechaHoraEliminacion) {
        $this->fechahora_eliminacion = $fechaHoraEliminacion;
    }
    
    /**
     * 
     * @return int
     */
    public function getFechaHoraEliminacion(): ?int {
       return $this->fechahora_eliminacion; 
    }

    // Métodos sobrescritos de la interfaz IEntity
    
    public function getProtectedsKeys(): array {
        $protecteds = ["registro_eliminado", "usuario_id_eliminacion", "fechahora_eliminacion"];
        
        return array_merge($protecteds, $this->protecteds); // Retornando claves de protección
    }
}