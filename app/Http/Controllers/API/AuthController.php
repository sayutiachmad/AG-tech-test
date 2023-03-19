<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function register(){

        // validate input from user
        $validator = Validator::make(request()->all(), [
            'name'                  => 'required',
            'email'                 => 'required|email|unique:users',
            'username'              => 'required|alpha_num:ascii|unique:users',
            'password'              => 'required|confirmed',
        ]);

        // response for invalid validation
        if ($validator->fails()) {
            return response()
                ->json(
                    array(
                        'result' => false,
                        'response' => array(
                            'type' => 1,
                            'msg' => $validator->errors()
                        )
                    )
                );
        }

        $user = User::create([
            'name'          => request('name'),
            'email'         => request('email'),
            'username'      => request('username'),
            'password'      => Hash::make(request('password'))
        ]);


        // check storing result
        if (!$user->exists) {
            return response()->json(array('result' => false, 'response' => array('type' => 0, 'msg' => 'Terjadi kesalahan saat menyimpan data')));
        }

        // everything good, return success response
        return response()->json(array('result' => true, 'response' => array('type' => 0, 'msg' => 'Pendaftaran sukses')));


    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {   
        try {

            $loginType = filter_var(request('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            $credentials = [ $loginType => request('email'), 'password' => request('password')];

            if (!$token = auth()->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            return $this->respondWithToken($token);
        } catch (\Throwable $th) {
            return response()->json(array('result' => true, 'response' => array('type' => 0, 'msg' => 'Login gagal')));
        }
        
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
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
            'result' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 120
        ]);
    }
}