<?php

namespace Xofttion\Project\Contracts;

interface IAuthenticated {
    
    // Métodos de la interfaz IAuthenticated
    
    /**
     * 
     * @return bool
     */
    public function exists(): bool;
    
    /**
     * 
     * @return void
     */
    public function start(): void;
    
    /**
     * 
     * @return void
     */
    public function destroy(): void;
    
    /**
     * 
     * @param string $key
     * @param object $value
     * @return void
     */
    public function attach(string $key, $value): void;
    
    /**
     * 
     * @param string $key
     * @return bool
     */
    public function contains(string $key): bool;

    /**
     * 
     * @param string $key
     * @return void
     */
    public function detach(string $key): void;
    
    /**
     * 
     * @param object $key
     */
    public function getValue(string $key);
    
    /**
     * 
     * @param int $id
     * @return void
     */
    public function attachUserId(int $id): void;

    /**
     * 
     * @return int|null
     */
    public function getUserId(): ?int;
    
    /**
     * 
     * @return string
     */
    public function getKey(): string;
}