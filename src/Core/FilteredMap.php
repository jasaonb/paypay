<?php
namespace Dolores\Core;

class FilteredMap{
    private $map;

    public function __construct(array $baseMap){
        $this->map=$baseMap;
    }
    public function has(string $name):bool{
        return isset($this->map[$name]);
    }

    public function get(string $name){
        return $this->map[$name]??null;
    }
}