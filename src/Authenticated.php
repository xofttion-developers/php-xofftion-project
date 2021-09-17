<?php

namespace Xofttion\Project;

use Xofttion\Kernel\Contracts\IJson;
use Xofttion\Kernel\Structs\Json;

use Xofttion\Project\Contracts\IAuthenticated;

class Authenticated implements IAuthenticated
{

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
    private $resources;

    // Constructor de la clase Authenticated

    private function __construct()
    {

    }

    // Métodos de la clase Authenticated

    /**
     * 
     * @return Authenticated
     */
    public static function getInstance(): IAuthenticated
    {
        if (is_null(self::$instance)) {
            self::$instance = new static ();
        }

        return self::$instance;
    }

    /**
     * 
     * @return IJson|null
     */
    protected function getResources(): ?IJson
    {
        return $this->resources;
    }

    // Métodos sobrescritos de la interfaz IAuthenticated

    public function exists(): bool
    {
        return is_defined($this->resources);
    }

    public function start(): void
    {
        if (!$this->exists()) {
            $this->resources = new Json();
        }
    }

    public function destroy(): void
    {
        $this->resources = null;
    }

    public function attach(string $key, $value): void
    {
        if ($this->exists()) {
            $this->resources->attach($key, $value);
        }
    }

    public function detach(string $key): void
    {
        if ($this->exists()) {
            $this->resources->detach($key);
        }
    }

    public function contains(string $key): bool
    {
        return !$this->exists() ? false : $this->resources->contains($key);
    }

    public function getValue(string $key)
    {
        return !$this->exists() ? null : $this->resources->getValue($key);
    }

    public function putUserId(int $id): void
    {
        $this->attach("userId", $id);
    }

    public function getUserId(): ?int
    {
        return $this->getValue("userId");
    }
}
