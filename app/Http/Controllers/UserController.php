<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request)
    {

        $email = $request->email;
        $password = $request->password;

        $data = [
            'email' => $email,
            'password' => $password,
        ];

        return $data;
    }
    
}
