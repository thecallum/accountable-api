<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

          if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }

    public function register(Request $request)
    {

         $data = [
            "name" => filter_var($request->name, FILTER_SANITIZE_STRING),
            "email" => filter_var($request->email, FILTER_SANITIZE_EMAIL),
            "password" => filter_var($request->password, FILTER_SANITIZE_STRING),
            "errors" => []
        ];

        if (!(strlen($data['name']) >= 2 && strlen($data['name']) <= 20)) {
            $data['errors']['name'] = 'Name must be between 2-20 characters';
        } 
        

         if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $data['errors']['email'] = 'Enter a valid email.';
        } 
        
        if (!(strlen($data['password']) >= 8 && strlen($data['password']) <= 100)) {
            $data['errors']['password'] = 'Password must be between 8-100 characters.';
        } 

        // Check if valid data was sent
        if (sizeof($data['errors']) > 0) {
            return response()->json(['message' => 'Invalid Data', "errors" => $data['errors']]);
        }

        // hash password
        $data['password'] = bcrypt($data['password']);

        $user = User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => $data['password'],
        ]);

        if (!$user) {
           return response()->json(['message' => 'Internal Error']); 
        }

        $token = auth()->login($user);

        return response()->json(['message' => 'success', "token" => $token]); 
    }
}
