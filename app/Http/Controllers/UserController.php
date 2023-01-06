<?php

namespace App\Http\Controllers;

use App\Student;
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

    public function students(Request $request){
        $users = User::with('student')->where('role', "STUDENT")->get();
        return response()->json($users,Response::HTTP_OK);
    }

    public function profile(Request $request,$id){
        $user = User::where('id',$id)->first();
        $student = Student::where('user_id',$id)->first();
        $data = ['user'=>$user,'student'=>$student];
        return response()->json($data,Response::HTTP_OK);
    }
}
