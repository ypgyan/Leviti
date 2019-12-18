<?php

namespace Src\Users\Services;

use App\User;
use Respect\Validation\Validator as v;

class UsersService 
{
    /**
     * Mensagem de retorno 
     *
     * @var string
     */
    private $message = [];

    /**
     * Verifica se o CPF é valido
     * 
     * @param string $cpf
     * @return bool
     */
    public function verificaCPF(string $cpf)
    {
        $user = User::where('cpf', $cpf)->first();

        if (!empty($user) || !empty($user->api_token)) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Verifica os dados recebidos
     * 
     * @param Array userData
     * @return Array[bool,string]
     */
    public function validate(Array $userData)
    {
        if (!v::stringType()->validate($userData["name"])) {
            $this->message["name"] = "The name field needs to be string";
        }

        if (!v::stringType()->validate($userData["last_name"])) {
            $this->message["last_name"] = "The last name field needs to be string";
        }

        if (!v::cpf()->validate($userData["cpf"]) || $this->verificaCPF($userData["cpf"])) {
            $this->message["cpf"] = "This CPF is invalid or has already been taken";
        }

        if (!v::stringType()->validate($userData["cellphone"])) {
            $this->message["cellphone"] = "The cellphone field needs to be string";
        }

        if (!v::email()->validate($userData["email"])) {
            $this->message["email"] = "Email is not valid";
        }

        if (!v::stringType()->validate($userData["type"])) {
            $this->message["type"] = "The type field needs to be string";
        }

        if (!v::boolVal()->validate($userData["status"])) {
            $this->message["status"] = "The status field needs to be bool";
        }

        if (empty($this->message)) {
            return [
                "validated" => 1,
                "message" => $this->message
            ];
        }else{
            return [
                "validated" => 0,
                "message" => $this->message
            ];
        }
        
    }

    /**
     * Insere o usuário na base
     *
     * @param Array $userData
     * @return void
     */
    public function insert(Array $userData)
    {
        $user = new User();

        $user->name = $userData["name"];
        $user->last_name = $userData["last_name"];
        $user->cpf = $userData["cpf"];
        $user->cellphone = $userData["cellphone"];
        $user->email = $userData["email"];
        $user->type = $userData["type"];
        $user->status = $userData["status"];

        $user->save();
    }
}