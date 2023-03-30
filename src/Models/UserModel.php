<?php
namespace Dolores\Models;
use Dolores\Core\Exceptions\DatabaseException;
use Dolores\Core\Exceptions\NotFoundException;
use PDO;
use Dolores\Models\Data\User;
use Dolores\Core\Exceptions\UserAlreadyExistException;

class UserModel extends AbstractModel{
    public function get(array $params):User{
       
        $query="SELECT * FROM users where";
        $a=[];
        foreach($params as $key => $param){
            $query=$query." $key =:$key and";
            $a[$key]=$param;
        }
       
       
        $query=substr($query,0,strlen($query)-4);
  
        $sth=$this->db->prepare($query);
        $sth->execute($a);

        $row=$sth->fetch();

        if(empty($row)){
            //user has not been registered
            throw new NotFoundException();
        }

        return new User($row['id'],
        $row['email'],"");
    }

    public function addUser(string $email,string $password):bool{
        $query=<<<SQL
        INSERT INTO users (email,password)
        VALUES(:email,:password)
        SQL;

        $params=[
            "email"=>$email,
            "password"=>$password
        ];

        $sth=$this->db->prepare($query);
        return $sth->execute($params);
    }

    public function register(string $email,string $password):bool{
        //check if has the user 
        try{
            $params=[
                "email"=>$email
            ];
            $row=$this->get($params);
            //can not register
            throw new UserAlreadyExistException();
        }catch(NotFoundException $e){
            //can register
            if(!$this->addUser($email,$password)){
                throw new DatabaseException();
            }
            return true;

        }
    }
}
