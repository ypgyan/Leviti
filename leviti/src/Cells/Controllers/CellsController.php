<?php

namespace Src\Cells\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Src\Cells\Services\CellsService;

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
     * Serviço de usuários
     * 
     * @var CellsService
     */
    private $cells;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CellsService $cellsService)
    {
        $this->cells = $cellsService;
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

            $validate = $this->cells->validate($data);

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
}
