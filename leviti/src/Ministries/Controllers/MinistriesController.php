<?php

namespace Src\Ministries\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
            $this->response["message"] = "Ministérios retornados com sucesso";
            $this->response["ministries"] = $ministries;
        } catch (\Exception $e) {
            Log::error('Falha ao busca os ministérios');
            $this->response["status"] = "error";
            $this->response["message"] = "Falha ao buscar os ministérios";
        }
        return response()->json($this->response);
    }

    /**
     * Salva o ministério
     * 
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string'
        ]);

        try {
            $data = $request->all();

        
            $this->ministryService->insert($data);
            $this->response["status"] = "success";
            $this->response["message"] = "Ministry inserted succesfully";
            Log::info('New Ministry created by: User ' . Auth::user()->id);
            
            return response()->json($this->response);
        } catch (\Exception $e) {
            Log::critical('Ministry store Error: ' . $e->getMessage());

            $this->response["message"] = "Something went wrong with the insert of the ministry";
            $this->response["status"] = "error";

            return response()->json($this->response);
        }
    }

    /**
     * Retorna um ministério específico
     * 
     * @param int $idMinistry
     * @return Json
     */
    public function show(int $idMinistry)
    {
        try {
            $ministry = $this->ministryService->get($idMinistry);

            $this->response["status"] = "success";
            $this->response["message"] = "Ministérios retornados com sucesso";
            $this->response["ministry"] = $ministry;
        } catch (\Exception $e) {
            Log::error('Falha ao busca os ministérios');
            $this->response["status"] = "error";
            $this->response["message"] = "Falha ao buscar os ministérios";
        }
        return response()->json($this->response);
    }

    /**
     * Atualiza as informações de um ministério
     * 
     * @param Request $request
     * @param int $idMinistry
     * @return Response
     */
    public function update(Request $request, int $idMinistry)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|bool'
        ]);

        try {
            $data = $request->all();

        
            $this->ministryService->update($data, $idMinistry);
            $this->response["status"] = "success";
            $this->response["message"] = "Ministry updated succesfully";
            Log::info('Ministry updated by: User ' . Auth::user()->id);
            
            return response()->json($this->response);
        } catch (\Exception $e) {
            Log::critical('Ministry update Error: ' . $e->getMessage());

            $this->response["message"] = "Something went wrong with the update of the ministry";
            $this->response["status"] = "error";

            return response()->json($this->response);
        }
    }

    /**
     * Deleta o ministério desejado
     * 
     * @param int $idMinistries
     * @return Response
     */
    public function delete(int $idMinistries)
    {
        try {
            DB::beginTransaction();

            $this->ministryService->deleteMinistriesUsers($idMinistries);
            $this->ministryService->delete($idMinistries);
            $this->response["status"] = "success";
            $this->response["message"] = "Ministry succesfully deleted";
            
            Log::info('Ministry deleted by: User ' . Auth::user()->id);
            DB::commit();
            return response()->json($this->response);
        } catch (\Exception $e) {
            DB::rollback();
            Log::critical('Ministry delete Error: ' . $e->getMessage());

            $this->response["message"] = "Something went wrong with the delete of the Ministry";
            $this->response["status"] = "error";
            return response()->json($this->response);
        }
    }
}
