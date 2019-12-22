<?php

namespace Src\Cells\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Respect\Validation\Validator as v;
use Src\Cells\Models\Cell;

class CellsService
{
    /**
     * Mensagem de retorno 
     *
     * @var string
     */
    private $message = [];

    /**
     * Retorna todos as células cadastrados
     *
     * @param void
     * @return Array
     */
    public function getAll()
    {
        $cells = DB::select("
            SELECT
                C.*
            FROM cells C
        ");

        return $cells;
    }

    /**
     * Verifica os dados recebidos
     * 
     * @param Array $cellData
     * @return Array[bool,string]
     */
    public function validate(Array $cellData)
    {
        if (!v::stringType()->validate($cellData["name"])) {
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
     * @param Array $cellData
     * @return void
     */
    public function insert(Array $cellData)
    {
        $cell = new Cell();

        $cell->id_user = Auth::user()->id;
        $cell->name = $cellData["name"];
        $cell->description = $cellData["description"];

        $cell->save();
    }
}