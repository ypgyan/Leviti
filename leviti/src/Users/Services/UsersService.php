<?php

namespace Src\Users\Services;

use App\User;
use Illuminate\Support\Facades\DB;
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
        $user->type = strtoupper($userData["type"]);
        $user->status = $userData["status"];

        $user->save();
    }

    /**
     * Retorna todos os users
     * @param void
     * @return Array
     */
    public function getAll()
    {
        $users = DB::select("
            SELECT 
                U.id,
                U.name,
                U.last_name,
                CONCAT(U.name,' ', U.last_name) AS full_name,
                U.cpf,
                U.cellphone,
                U.email,
                U.type,
                U.active,
                U.status,
                U.created_at,
                U.updated_at
            FROM users U
            WHERE
                U.status = 1
        ");

        return $users;
    }

    /**
     * Retorna o usuário
     * @param int $idUser
     * @return Array
     */
    public function get(int $idUser)
    {
        $users = DB::select("
            SELECT 
                U.id,
                U.name,
                U.last_name,
                CONCAT(U.name,' ', U.last_name) AS full_name,
                U.cpf,
                U.cellphone,
                U.email,
                U.type,
                U.active,
                U.status,
                U.created_at,
                U.updated_at
            FROM users U
            WHERE
                id = ?
        ",[$idUser]);

        return $users;
    }

    /**
     * Atualizado os dados do usuário
     * 
     * @param Array $userData
     * @param int $idUser
     * @return void
     */
    public function update(Array $userData, int $idUser)
    {
        $user = User::where('id',$idUser)->first();

        $user->name = $userData["name"];
        $user->last_name = $userData["last_name"];
        $user->cpf = $userData["cpf"];
        $user->cellphone = $userData["cellphone"];
        $user->email = $userData["email"];
        $user->type = $userData["type"];
        $user->active = $userData["active"];
        $user->status = $userData["status"];

        $user->save();
    }

    /**
     * Deleta o usuário
     * 
     * @param int $idUser
     * @return void
     */
    public function delete(int $idUser)
    {
        $user = User::where('id',$idUser)->first();

        $user->status = 0;

        $user->save();
    }
}