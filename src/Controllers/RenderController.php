<?php
namespace Dolores\Controllers;

class RenderController extends AbstractController{
    public function home(){
        $this->render("home");
    }
    public function login(){
        $this->render("login");
    }
}