<?php

namespace Src\Cells\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Src\Cells\Services\CellsService;
use Src\Cells\Services\ValidateService;

class CellsController extends Controller
{

    /**
     * Response Array
     */
    private $response = [
        "status" => "",
        "message" => ""
    ];

    /**
     * Serviço de células
     * 
     * @var CellsService
     */
    private $cells;

    /**
     * Serviço de validação
     * 
     * @var CellsService
     */
    private $validate;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CellsService $cellsService, ValidateService $validateService)
    {
        $this->cells = $cellsService;
        $this->validate = $validateService;
    }

    /**
     * Retorna todos as células cadastradas
     * 
     * @param void
     * @return Json
     */
    public function index()
    {
        try {
            $cells = $this->cells->getAll();

            $this->response["status"] = "success";
            $this->response["message"] = "Succesfully found the cells";
            $this->response["cells"] = $cells;
        } catch (\Exception $e) {
            Log::error('Something went wrong trying to get the cells: '. $e->getMessage());
            $this->response["status"] = "error";
            $this->response["message"] = "Failed to get cells";
        }
        return response()->json($this->response);
    }

    /**
     * Salva a célula
     * 
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $validate = $this->validate->store($data);

            if($validate["validated"]){
                $this->cells->insert($data);
                $this->response["status"] = "success";
                $this->response["message"] = "Cell inserted succesfully";
                Log::info('New Cell created by: User ' . Auth::user()->id);
            }else{
                $this->response["status"] = "error";
                $this->response["message"] = $validate["message"];
            }
            return response()->json($this->response);
        } catch (\Exception $e) {
            Log::critical('Cell store Error: ' . $e->getMessage());

            $this->response["message"] = "Something went wrong with the insert of the cell";
            $this->response["status"] = "error";

            return response()->json($this->response);
        }
    }

    /**
     * Busca uma célula específica
     * 
     * @param void
     * @return Json
     */
    public function show($id_cell)
    {
        try {
            $cells = $this->cells->get($id_cell);

            $this->response["status"] = "success";
            $this->response["message"] = "Succesfully found the cell";
            $this->response["cells"] = $cells;
        } catch (\Exception $e) {
            Log::error('Something went wrong trying to get the cell: id = '. $id_cell .' error = ' .$e->getMessage());
            $this->response["status"] = "error";
            $this->response["message"] = "Failed to get cell";
        }
        return response()->json($this->response);
    }

    /**
     * Atualiza os dados da célula
     * 
     * @param Request $request
     * @return Response
     */
    public function update(Request $request, $id_cell)
    {
        try {
            $data = $request->all();

            $validate = $this->validate->update($data);

            if($validate["validated"]){
                $this->cells->update($data, $id_cell);
                $this->response["status"] = "success";
                $this->response["message"] = "Cell inserted succesfully";
                Log::info('Cell updated succesfully by: User ' . Auth::user()->id);
            }else{
                $this->response["status"] = "error";
                $this->response["message"] = $validate["message"];
            }
            return response()->json($this->response);
        } catch (\Exception $e) {
            Log::critical('Cell update Error: ' . $e->getMessage());

            $this->response["message"] = "Something went wrong with the update of the cell";
            $this->response["status"] = "error";

            return response()->json($this->response);
        }
    }

    /**
     * Deleta a célula desejada
     * 
     * @param Request $request
     * @return Response
     */
    public function delete($id_cell)
    {
        try {
            $validate = $this->validate->delete($id_cell);

            if($validate["validated"]){
                DB::beginTransaction();
                $this->cells->deleteCellUsers($id_cell);
                $this->cells->delete($id_cell);
                $this->response["status"] = "success";
                $this->response["message"] = "Cell succesfully deleted";
                Log::info('Cell deleted by: User ' . Auth::user()->id);
                DB::commit();
            }else{
                $this->response["status"] = "error";
                $this->response["message"] = $validate["message"];
            }
            return response()->json($this->response);
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('Cell delete Error: ' . $e->getMessage());

            $this->response["message"] = "Something went wrong with the delete of the cell";
            $this->response["status"] = "error";

            return response()->json($this->response);
        }
    }
}
