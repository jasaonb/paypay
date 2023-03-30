<?php
namespace Dolores\Core;


class SendJson{
    private $data;
    public function __construct($data)
    {
        $this->data=$data;
    }
    public function getData(){
        return json_encode($this->data);
    }
}