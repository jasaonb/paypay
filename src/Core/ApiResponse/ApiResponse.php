<?php
namespace Dolores\Core\ApiResponse;

use Dolores\Core\Const\FgConst;
use Dolores\Core\SendJson;

class ApiResponse{
    private $result;
    public function __construct()
    {
        $this->result["code"]=FgConst::$SUCEESS;
    }

    public function setFailed():ApiResponse{
        $this->result["code"]=FgConst::$FAILD;
        return $this;
    }

    public function setMessage(string $message):ApiResponse{
        $this->result["message"]=$message;
        return $this;
    }
    public function setData($data):ApiResponse{
        $this->result["data"]=$data;
        return $this;
    }

    public function getResult():SendJson{
        return new SendJson($this->result);
    }
}