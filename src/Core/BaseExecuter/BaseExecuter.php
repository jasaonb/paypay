<?php
namespace Dolores\Core\BaseExecuter;
use Dolores\Core\Request;

interface BaseExecuter{
    public function executerController(string $route,string $path,array $info,Request $request);
}