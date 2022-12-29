<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function login(Request $request){
        $user = User::where('email', $request->email)->first();
        if($user && password_verify($request->password, $user->password)) {
            $data=['message'=>'Logged In','user'=>$user,'token'=>base64_encode(json_encode($user))];
            return response()->json($data,Response::HTTP_OK);
         }else{
            return response()->json(['message'=>'incorrect username or password'],Response::HTTP_BAD_REQUEST);
         }
    }
}
