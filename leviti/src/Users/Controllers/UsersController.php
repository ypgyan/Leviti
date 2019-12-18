<?php

namespace Src\Users\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Src\Users\Services\UsersService;

class UsersController extends Controller
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
     * @var UsersService
     */
    private $usersService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    /**
     * Index de Users
     * 
     * @param void
     * @return Json
     */
    public function index()
    {
        $this->response["status"] = "Success";
        $this->response["message"] = "This is the Users section of Levíti API and it's working ^^";
        return response()->json($this->response);
    }

    /**
     * Save the users
     * 
     * @param void
     * @return Json
     */
    public function store(Request $request)
    {
        //dd($request->all());
        try {
            $data = $request->all();

            $validate = $this->usersService->validate($data);

            if($validate["validated"]){
                $this->usersService->insert($data);
                $this->response["status"] = "success";
                $this->response["message"] = "User inserted succesfully";
            }else{
                $this->response["status"] = "error";
                $this->response["message"] = $validate["message"];
            }

            return response()->json($this->response);
        } catch (\Exception $e) {
            Log::critical('Users store Error: ' . $e->getMessage());

            $this->response["message"] = "Alguma coisa deu errado ao tentar salvar o usuário";
            $this->response["status"] = "error";

            return response()->json($this->response);
        }
    }
}
