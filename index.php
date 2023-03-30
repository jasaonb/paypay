<?php
require_once(__DIR__.'/vendor/autoload.php');
use Dolores\Core\Request;
use Dolores\Core\Router;



$request=new Request();
//echo $request->getPath();



// var_dump($request);

$router=new Router();
$router->route($request);