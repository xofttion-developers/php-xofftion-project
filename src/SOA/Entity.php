<?php

namespace Xofttion\Project\SOA;

use Xofttion\SOA\Entity as BaseEntity;

class Entity extends BaseEntity
{

    // Atributos de la clase Entity

    /**
     *
     * @var int 
     */
    protected $id;

    /**
     *
     * @var int 
     */
    protected $usuario_id_registro;

    /**
     *
     * @var int 
     */
    protected $fechahora_registro;

    /**
     *
     * @var int 
     */
    protected $usuario_id_actualizacion;

    /**
     *
     * @var int 
     */
    protected $fechahora_actualizacion;

    // Métodos de la clase Entity

    /**
     * 
     * @param int $id
     */
    public function setId(?int $id)
    {
        $this->id = $id;
    }

    /**
     * 
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * 
     * @param int $usuarioIdRegistro
     */
    public function setUsuarioIdRegistro(?int $usuarioIdRegistro)
    {
        $this->usuario_id_registro = $usuarioIdRegistro;
    }

    /**
     * 
     * @return int
     */
    public function getUsuarioIdRegistro(): ?int
    {
        return $this->usuario_id_registro;
    }

    /**
     * 
     * @param int $fechaHoraRegistro
     */
    public function setFechaHoraRegistro(?int $fechaHoraRegistro)
    {
        $this->fechahora_registro = $fechaHoraRegistro;
    }

    /**
     * 
     * @return int
     */
    public function getFechaHoraRegistro(): ?int
    {
        return $this->fechahora_registro;
    }

    /**
     * 
     * @param int $usuarioIdActualizacion
     */
    public function setUsuarioIdActualizacion(?int $usuarioIdActualizacion)
    {
        $this->usuario_id_actualizacion = $usuarioIdActualizacion;
    }

    /**
     * 
     * @return int
     */
    public function getUsuarioIdActualizacion(): ?int
    {
        return $this->usuario_id_actualizacion;
    }

    /**
     * 
     * @param int $fechaHoraActualizacion
     */
    public function setFechaHoraActualizacion(?int $fechaHoraActualizacion)
    {
        $this->fechahora_actualizacion = $fechaHoraActualizacion;
    }

    /**
     * 
     * @return int
     */
    public function getFechaHoraActualizacion(): ?int
    {
        return $this->fechahora_actualizacion;
    }

    // Métodos sobrescritos de la interfaz IEntity

    public function setPrimaryKey(int $primaryKey): void
    {
        $this->id = $primaryKey;
    }

    public function getPrimaryKey(): ?int
    {
        return $this->id;
    }

    public function setParentKey(int $parentKey): void
    {
        $this->id = $parentKey;
    }

    public function getParentKey(): ?int
    {
        return $this->id;
    }
}
