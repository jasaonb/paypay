<?php
namespace Dolores\Controllers;

use Dolores\Core\ApiResponse\ApiResponse;
use Dolores\Core\Exceptions\UserAlreadyExistException;
use Dolores\Core\Exceptions\DatabaseException;
use Dolores\Core\Exceptions\NotFoundException;
use Dolores\Models\UserModel;


class LoginController extends AbstractController{
    public function login(string $email,string $password):ApiResponse{
        //header("Content-type:application/json");
        $userModel=new UserModel($this->db);
        $result=new ApiResponse();
        $params=[
            "email"=>$email,
            "password"=>$password
        ];
        try{
            $ret=$userModel->get($params);
        }catch(NotFoundException $e){
            $result->setFailed();
            $result->setMessage("account and password not matched");
        }
        return $result;
    }
    public function register(string $email,string $password):ApiResponse{
        $usermodel=new UserModel($this->db);
        $result=new ApiResponse();
        try{
            $usermodel->register($email,$password);
        }catch(UserAlreadyExistException $e){
            $result->setFailed()->setMessage("user is already exist!");
         
        }catch(DatabaseException $e){
            $result->setFailed()->setMessage("Database Error!!!");
        }
       
        return $result;
    }
}