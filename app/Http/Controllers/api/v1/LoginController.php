<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function setLogin(Request $request){
         
        
        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Usuario o contraseña incorrectas.'
            ], 401);


    
        $tokenResult = Auth::user()->createToken('authToken');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addMinute(1);
        $token->save();

        return response()->json([
            'user' => Auth::user(),
            'access_token' => $tokenResult->accessToken,
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);



        //  ESTE ES OTRA FORMA CORTA DE MANDAR EL TOKEN Y EL USUARIO
        // $accessToken = Auth::user()->createToken('authToken')->accessToken;
        // return response([
        //     'user' => Auth::user() , 'access_token' => $accessToken 
        // ]);
        

    }


    public function getLogout(Request $request)
    {
        // Con este metodo borramos unicamente el token del usuario donde haya iniciado sesion.
        $request->user()->token()->revoke();
        return response()->json(['message' => 
            'Successfully logged out']);
    }

    public function getLogoutAll()
    {  
        // Con este metodo eliminamos todos los token del usuario en la base de dato 
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json([
            'message' => 'Successfully logged out',
        ],200);
    }
}
