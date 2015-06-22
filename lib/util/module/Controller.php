<?php

namespace lib\util\module;

class Controller
{
    private $name;
    private $submodule;
    private $home;

    public static function createInstance()
    {
        return new Controller();
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSubmodule()
    {
        return $this->submodule;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setSubmodule($submodule)
    {
        $this->submodule = $submodule;
        return $this;
    }

    public function setHome($method)
    {
        $this->home = $method;
        return $this;
    }

    public function getHome()
    {
        return $this->home;
    }
}