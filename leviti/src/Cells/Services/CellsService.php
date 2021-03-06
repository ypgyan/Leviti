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
            WHERE
                status = 1
        ");

        return $cells;
    }

    /**
     * Retorna a célula desejada
     *
     * @param void
     * @return Array
     */
    public function get($id)
    {
        $cells = DB::select("
            SELECT
                C.*
            FROM cells C
            WHERE
                C.id = ? AND C.status = 1
        ",[$id]);

        return $cells;
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

    /**
     * Atualiza os dados da célula no banco
     *
     * @param Array $cellData
     * @param int $id_cell
     * @return void
     */
    public function update(Array $cellData, $id_cell)
    {
        $cell = Cell::where('id',$id_cell)->first();

        $cell->name = $cellData["name"];
        $cell->description = $cellData["description"];
        $cell->status = $cellData["status"];

        $cell->save();
    }

    /**
     * Deleta os usuários vinculados a célula
     *
     * @param int $id_cell
     * @return void
     */
    public function deleteCellUsers($id_cell)
    {
        DB::delete('
        UPDATE user_cells SET
            status = 0
        WHERE
            id_cell = ?
        ', [$id_cell]);
    }

    /**
     * Deleta a célula
     *
     * @param int $idCell
     * @return void
     */
    public function delete($idCell)
    {
        try {
            Cell::where('id', $idCell)->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function insertCellmembers(Array $members)
    {
        try {
            dd($members);
            foreach ($members as $member) {
                DB::insert('
                    INSERT INTO user_cells

                ', [1, 'Dayle']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
