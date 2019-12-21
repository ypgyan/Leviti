<?php

namespace Src\Ministries\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Src\Ministries\Services\MinistryService;

class MinistriesController extends Controller
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
     * @var MinistryService
     */
    private $ministryService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MinistryService $ministryService)
    {
        $this->ministryService = $ministryService;
    }

    /**
     * Retorna todos os ministérios cadastrados
     * 
     * @param void
     * @return Json
     */
    public function index()
    {
        try {
            $ministries = $this->ministryService->getAll();

            $this->response["status"] = "success";
            $this->response["message"] = "Ministérios retornado com sucesso";
            $this->response["ministries"] = $ministries;
        } catch (\Exception $e) {
            Log::error('Falha ao busca os ministérios');
            $this->response["status"] = "error";
            $this->response["message"] = "Falha ao buscar os ministérios";
        }
        return response()->json($this->response);
    }

    /**
     * Salvo o ministério
     * 
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $validate = $this->ministryService->validate($data);

            if($validate["validated"]){
                $this->ministryService->insert($data);
                $this->response["status"] = "success";
                $this->response["message"] = "Ministry inserted succesfully";
                Log::info('New Ministry created by: User ' . Auth::user()->id);
            }else{
                $this->response["status"] = "error";
                $this->response["message"] = $validate["message"];
            }
            return response()->json($this->response);
        } catch (\Exception $e) {
            Log::critical('Ministry store Error: ' . $e->getMessage());

            $this->response["message"] = "Something went wrong with the insert of the ministry";
            $this->response["status"] = "error";

            return response()->json($this->response);
        }
    }
}
