<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    private $responseOk = 200;
    private $responseBad = 502;

    // return all user registered
    public function index(){
        $userCount = User::count();

        if($userCount!=0){
            return User::all();
        }else{
            return response()->json([
                "status" => $this->responseBad
            ]);
        }
    }

    public function getUserById($id){
        $user = User::find($id);

        if($user != null || $user != ""){
            return $user;
        }else{
            return response()->json([
                "status" => $this->responseBad
            ]);
        }
        
    }

    public function createUser(Request $request){
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = md5($request->password);

        if($user->save()){
            return response()->json([
                "status" => $this->responseOk
            ]);
        }else{
            return response()->json([
                "status" => $this->responseBad
            ]);
        }
    }

    public function updateUser(Request $request, $id){
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;

        if($user->save()){
            return response()->json([
                "status" => $this->responseOk
            ]);
        }else{
            return response()->json([
                "status" => $this->responseBad
            ]);
        }
    }

    public function deleteUser($id){
        $user = User::find($id);
        
        if($user->delete()){
            return response()->json([
                "status" => $this->responseOk
            ]);
        }else{
            return response()->json([
                "status" => $this->responseBad
            ]);
        }
    }
}
