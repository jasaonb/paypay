<?php
namespace Dolores\Core\BaseExecuter;

use Dolores\Core\ApiResponse\ApiResponse;
use Dolores\Core\Request;
use Dolores\Core\Const;
use Dolores\Core\Const\FgConst;
use Dolores\Core\SendJson;
use Exception;

class ApiExecuter implements BaseExecuter{

    private function getBody(){
        $post=file_get_contents("php://input");
        $request=json_decode($post,true);
        return $request??[];
    }
    public function executerController(string $route,string $path,array $info,Request $request):SendJson{
      
        $post=$this->getBody();
            try{
                $controllerName='\Dolores\Controllers\\'.$info['controller'].'Controller';
                $controller=new $controllerName($request);
                //ApiReponse()
                $ret=call_user_func_array([$controller,$info['method']],$post);
                return $ret->getResult();
            }catch(Exception $e){
                $ret=new ApiResponse();
                return $ret->setFailed()
                ->setMessage("api query error".$e->getMessage())->getResult();
            }
            
    }
}