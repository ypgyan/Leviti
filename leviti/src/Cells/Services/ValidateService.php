<?php

namespace Src\Cells\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Respect\Validation\Validator as v;
use Src\Cells\Models\Cell;

class ValidateService
{
    /**
     * Mensagem de retorno 
     *
     * @var string
     */
    private $message = [];

    /**
     * Verifica os dados recebidos store
     * 
     * @param Array $cellData
     * @return Array[bool,string]
     */
    public function store(Array $cellData)
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
     * Verifica os dados recebidos no update
     * 
     * @param Array $cellData
     * @return Array[bool,string]
     */
    public function update(Array $cellData)
    {
        if (!v::stringType()->validate($cellData["name"])) {
            $this->message["name"] = "The name field needs to be string";
        }

        if (!v::boolType()->validate($cellData["staus"])) {
            $this->message["name"] = "The status field needs to be boolean";
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
     * Verifica se a célula existe
     * 
     * @param int $id_cell
     * @return Array[bool,string]
     */
    public function delete(int $id_cell)
    {
        $cell = Cell::where('id',$id_cell)->first();


        if (!empty($cell) && $cell["status"] == 0) {
            return [
                "validated" => 1,
                "message" => "Cell found and is able to delete"
            ];
        }else{
            return [
                "validated" => 0,
                "message" => "Cell need to exists and need to be deactivated to be deleted"
            ];
        }
    }
}