<?php

namespace Src\Users\Controllers;

use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Index de Users
     * 
     * @param void
     * @return Json
     */
    public function index()
    {
        $response = [
            "status" => "Success",
            "message" => "This is the Users section of Levíti API and it's working ^^"
        ];
        return response()->json($response);
    }
}
