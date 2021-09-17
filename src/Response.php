<?php

namespace Xofttion\Project;

class Response
{

    // Atributos de la clase Response

    /**
     *
     * @var bool 
     */
    private $success;

    /**
     *
     * @var int 
     */
    private $code;

    /**
     *
     * @var array 
     */
    private $data;

    /**
     *
     * @var string 
     */
    private $message;

    // Constructor de la clase Response

    /**
     * 
     * @param bool $success
     * @param string|null $message
     * @param int $code
     * @param object $data
     */
    public function __construct(bool $success, ?string $message, int $code, $data = null)
    {
        $this->success = $success;
        $this->code = $code;
        $this->data = $data;
        $this->message = $message;
    }

    // Métodos de la clase Response

    /**
     * 
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * 
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * 
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * 
     * @return object
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 
     * @return array
     */
    public function toJson(): array
    {
        return [
            "success" => $this->success,
            "data" => $this->data,
            "message" => $this->message
        ];
    }
}
