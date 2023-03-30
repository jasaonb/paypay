<?php
namespace Dolores\Controllers;
use Dolores\Config\Config;
use Dolores\Core\Request;
use Dolores\Core\Db;
use Exception;

abstract class AbstractController{
    protected $request;
    protected $db;
    protected $config;


    public function __construct(Request $request){
        $this->request=$request;
        $this->db=Db::getInstance();
      
        $this->config=Config::getInstance();
    }
    public function render(string $template){
        try{
            $tmp=__DIR__."/../tmpView/".$template.".html";
            readfile($tmp);
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
}