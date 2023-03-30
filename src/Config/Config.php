<?php
namespace Dolores\Config;

class Config{
    private static $instance;

    private $db;
    public static function getInstance():Config{
        if(self::$instance==null){
            self::$instance=new Config();
        }
        return self::$instance;
    }

    private function __construct(){
        $content=file_get_contents(__DIR__."/config.json");
        $this->db=json_decode($content,true);
    }

    public function get($name):array{
        return $this->db[$name]??[];
    }
}