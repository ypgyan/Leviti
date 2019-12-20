<?php

namespace Src\Ministrys\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MinistryController extends Controller
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
    public function __construct()
    {
        //
    }

    /**
     * Index de Users
     * 
     * @param void
     * @return Json
     */
    public function index()
    {
        return response()->json(['Rota de ministérios']);
    }

    /**
     * Save the users
     * 
     * @param void
     * @return Json
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Retorna todo os usuários
     */
    public function users()
    {
        //
    }
}
