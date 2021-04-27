<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\RequestHelper;
use Symfony\Component\HttpFoundation\Response;

class UpdatePwdController extends Controller{

    public function updatePassword(RequestHelper $request){
        return $this->validateToken($request)->count() > 0 ? $this->changePassword($request) : $this->noToken();
    }
    
    public function validateToken($request){
        return DB::table('password_resets')->where([
            'email' => $request->email,
            'token' => $request->token,
        ]);

    }
    
    public function changePassword($request){
        $user = User::whereEmail($request->email)->first();
        $user->update([
            'password' => bcrypt($request->password)
        ]);
        $this->validateToken($request)->delete();
        return response()->json([
            'message' => 'Password changed succefully.'
        ], Response::HTTP_CREATED);
    }

    public function noToken(){
        return response()->json([
            'error' => 'Email or Token does not exist.'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
