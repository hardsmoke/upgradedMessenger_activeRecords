<?php

namespace Messenger\DI;

class ServiceLocator
{
    private array $services = [];

    public function Set(string $name, $service)
    {
        $this->services[$name] = $service;
    }

    public function Get(string $name)
    {
        if (isset($this->services[$name]) && is_callable($this->services[$name]))
        {
            $this->services[$name] = $this->services[$name]($this);
        }

        return $this->services[$name];
    }
}