<?php
namespace Dolores\Core;

use Dolores\Core\ApiResponse\ApiResponse;
use Dolores\Core\BaseExecuter\ApiExecuter;
use Dolores\Core\BaseExecuter\RenderExecuter;

class Router{
    private $routeMap;
    private $apiRouteMap;
    private static $regrxPatters=[
        'number'=>'\d+',
        'string'=>'\w+'
    ];

    public function __construct(){
        // echo __DIR__.'/../Router/router.json';
        $json=file_get_contents(__DIR__.'/../Router/router.json');
        $this->routeMap=json_decode($json,true);
        $json=file_get_contents(__DIR__.'/../Router/api.json');
        $this->apiRouteMap=json_decode($json,true);
        //echo $json;
    }

    public function route(Request $request):void{
        $path=$request->getPath();
    //     echo $path;
    //     //if the prefix with api go to parse the api.json
    //    var_dump(strpos($path,'/api'));
       if(strpos($path,"/api")!=false){
            foreach($this->apiRouteMap as $route=>$info){
                if(preg_match("@/api/$route@",$path)){
                    //sendJson return 
                    $apiExecuter=new ApiExecuter();
                    $ret=$apiExecuter->executerController($route,$path,$info,$request);
                    echo $ret->getData();
                    return;
                }
            }
            //not one found
            $apiReponse=new ApiResponse();
            echo $apiReponse->setFailed()->setMessage("APi Error , Not Found")->getResult()->getData();
            return;
            
        }else{
            $p=substr($path,strlen("/pay/pay/")-1);
            foreach($this->routeMap as $route=>$info){

                if(strlen($p)==0){
                    echo $p;
                    //go to the home
                    $render=new RenderExecuter();
                   //$render->executerController($route,$path,$info,$request);
                    return;
                }
                else{
                    if(empty($route)){
                        continue;
                    }
                    $regexRoute=$this->getRegexValue($route,$info);
                    // $regexRoute="/paypay/index.php/".$regexRoute;
    
                    $isRender=false;
    
                    if(isset($info["render"])){
                        $isRender=true;
                    }
                  
                   
                    if(preg_match("@/$regexRoute$@",$path)){

                        $render=new RenderExecuter();
                        $render->executerController($route,$path,$info,$request,$isRender);
                        return;
                    }
                }
               
            }
        }
        echo "404";
    }

    private function getRegexValue(string $route,array $info){
        if(isset($info['params'])){
            foreach($info['params'] as $name=>$type){
                $route=str_replace(':'.$name,self::$regrxPatters[$type],$route);

            }
        }
        return $route;
    }

    private function extractParams(string $route,string $path):array{
        $params=[];

        $pathParts=explode('/',$path);
        $routeParts=explode('/',$route);

        foreach($routeParts as $key => $routePart){
            //check the :123123
            if(strpos($routePart,':')===0){
                $name=substr($routePart,1);
                $params[$name]=$pathParts[$key+1];
            }
        }
        return $params;
    }

    
}