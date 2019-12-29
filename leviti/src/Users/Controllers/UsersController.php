<?php

namespace Src\Users\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        try {
            $users = $this->usersService->getAll();
            $this->response["users"] = $users;
            $this->response["message"] = "Usuários retornados com sucesso";
            $this->response["status"] = "success";
        } catch (\Exception $e) {
            Log::critical('Users store Error: ' . $e->getMessage());
            $this->response["message"] = "Alguma coisa deu errado ao tentar buscar os usuários";
            $this->response["status"] = "error";
        }
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
        $this->validate($request, [
            'name' => 'required|string',
            'last_name' => 'required|string',
            'cpf' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'type' => 'required|string'
        ]);

        try {
            $data = $request->all();

            $this->usersService->insert($data);
            $this->response["status"] = "success";
            $this->response["message"] = "User inserted succesfully";
            Log::info('New user created by: User ' . Auth::user()->id);
            
            return response()->json($this->response);
        } catch (\Exception $e) {
            Log::critical('Users store Error: ' . $e->getMessage());

            $this->response["message"] = "Something went wrong";
            $this->response["status"] = "error";

            return response()->json($this->response);
        }
    }

    /**
     * Mostra um usuário específico
     * 
     * @param int $idUser
     * @return Json
     */
    public function show(int $idUser)
    {
        try {
            $users = $this->usersService->get($idUser);
            $this->response["users"] = $users;
            $this->response["message"] = "Usuários retornado com sucesso";
            $this->response["status"] = "success";
        } catch (\Exception $e) {
            Log::critical('Users store Error: ' . $e->getMessage());
            $this->response["message"] = "Alguma coisa deu errado ao tentar buscar o usuário";
            $this->response["status"] = "error";
        }
        return response()->json($this->response);
    }

    /**
     * Atualiza os dados do usuário desejado
     * 
     * @param void
     * @return Json
     */
    public function update(Request $request, int $idUser)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'last_name' => 'required|string',
            'cpf' => 'required|string',
            'email' => 'required|email',
            'type' => 'required|string',
            'active' => 'required|bool',
            'status' => 'required|bool'
        ]);

        try {
            $data = $request->all();

            $this->usersService->update($data, $idUser);
            $this->response["status"] = "success";
            $this->response["message"] = "User updated succesfully";
            Log::info('User updated succesfully');
            
            return response()->json($this->response);
        } catch (\Exception $e) {
            Log::critical('User update Error: ' . $e->getMessage());

            $this->response["message"] = "Something went wrong";
            $this->response["status"] = "error";

            return response()->json($this->response);
        }
    }

    /**
     * Deleta o usuário desejada
     * 
     * @param int $idUser
     * @return Response
     */
    public function delete(int $idUser)
    {
        try {
            $this->usersService->delete($idUser);
            $this->response["status"] = "success";
            $this->response["message"] = "User succesfully deleted";
            
            Log::info('User disabled');
            return response()->json($this->response);
        } catch (\Exception $e) {
            Log::critical('User disabled Error:');

            $this->response["message"] = "Something went wrong with the delete of the user";
            $this->response["status"] = "error";
            return response()->json($this->response);
        }
    }
}
