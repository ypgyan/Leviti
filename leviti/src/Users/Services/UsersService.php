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
        try {
            $user = new User();

            $user->name = $userData["name"];
            $user->last_name = $userData["last_name"];
            $user->cpf = $userData["cpf"];
            $user->cellphone = $userData["cellphone"];
            $user->email = $userData["email"];
            $user->type = strtoupper($userData["type"]);
            $user->status = $userData["status"];

            $user->save();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Retorna todos os users
     * @param void
     * @return Array
     */
    public function getAll()
    {
        try {
            $users = User::get();

            return $users;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Retorna o usuário
     * @param int $idUser
     * @return Array
     */
    public function get(int $idUser)
    {
        try {
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
        } catch (\Throwable $th) {
            throw $th;
        }
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
        try {
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
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Deleta o usuário
     *
     * @param int $idUser
     * @return void
     */
    public function delete(int $idUser)
    {
        try {
            $user = User::where('id',$idUser)->delete();
        } catch (\Throwable $th) {
            Log::critical('Failed to delete user');
            throw $th;
        }
    }
}
