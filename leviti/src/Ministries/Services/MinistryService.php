<?php

namespace Src\Ministries\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Respect\Validation\Validator as v;
use Src\Ministries\Models\Ministry;

class MinistryService
{
    /**
     * Mensagem de retorno
     *
     * @var string
     */
    private $message = [];

    /**
     * Retorna todos os ministérios cadastrados
     *
     * @param void
     * @return Array
     */
    public function getAll()
    {
        $ministries = Ministry::get();

        return $ministries;
    }

    /**
     * Verifica os dados recebidos
     *
     * @param Array $ministryData
     * @return Array[bool,string]
     */
    public function validate(Array $ministryData)
    {
        if (!v::stringType()->validate($ministryData["name"])) {
            $this->message["name"] = "The name field needs to be string";
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
     * Insere o ministério no Banco
     *
     * @param Array $ministryData
     * @return void
     */
    public function insert(Array $ministryData)
    {
        $ministry = new Ministry();

        $ministry->id_user = Auth::user()->id;
        $ministry->name = $ministryData["name"];
        $ministry->description = $ministryData["description"];

        $ministry->save();
    }

    /**
     * Retorna o ministério Específico
     *
     * @param int $idMinistry
     * @return Array
     */
    public function get($idMinistry)
    {
        $ministry = Ministry::where('id', $idMinistry)->first();

        return $ministry;
    }

    /**
     * Atualiza o ministério no Banco
     *
     * @param Array $ministryData
     * @param int $idMinistry
     * @return void
     */
    public function update(Array $ministryData, int $idMinistry)
    {
        $ministry = Ministry::where('id',$idMinistry)->first();

        $ministry->name = $ministryData["name"];
        $ministry->description = $ministryData["description"];
        $ministry->status = $ministryData["status"];

        $ministry->save();
    }

    /**
     * Deleta os usuários vinculados a célula
     *
     * @param int $idMinistry
     * @return void
     */
    public function deleteMinistriesUsers($idMinistry)
    {
        DB::update('
        UPDATE user_ministries SET
            status = 0
        WHERE
            id_ministry = ?
        ', [$idMinistry]);
    }

    /**
     * Deleta a célula
     *
     * @param int $idMinistry
     * @return void
     */
    public function delete($idMinistry)
    {
        Ministry::where('id', $idMinistry)->delete();
    }
}
