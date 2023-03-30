<?php
namespace Dolores\Core\BaseExecuter;

use Dolores\Core\Request;
use Exception;

class RenderExecuter implements BaseExecuter{
    private $params;

    public function __construct()
    {
        $this->params=[];
    }
    public function setParams($params){
        $this->params=$params;
    }
    public function executerController(string $route,string $path,array $info,Request $request){
        $controllerName='\Dolores\Controllers\\'.$info['controller'].'Controller';
        $controller=new $controllerName($request);

        call_user_func_array([$controller,$info['method']],array_merge($this->params,$_GET));
    }
}