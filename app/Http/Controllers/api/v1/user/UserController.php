<?php

namespace App\Http\Controllers\api\v1\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    
   
   public function getList(){
    
   
       $user = User::all();

       return response()->json([
        'Users' =>  $user,
       ]);

   }

   public function setRegister(Request $request)
    {  
       
        $validator = Validator::make(request()->input(), [
            'name' => 'required|string|max:190',
            'email' => 'required|string|email|max:190|unique:users',
            // 'password' => 'required|string|min:6|confirmed',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(array(
                'status' => 'error',
                'errors' => $validator->getMessageBag()->toArray()
            ), 422);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'rol' => $request->rol,
            'password' => bcrypt($request->password)
        ]);

        return response()->json([
            'message' => 'Successfully created user!'
        ], 200);
    }
}
