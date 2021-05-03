<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ])->assignRole('Guest');

        
        //$user->roles()->attach(2); // Simple user role
        //$this->login($request);
        return response()->json($user);
    }

    public function login(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'email|required',
                'password' => 'required'
            ]);
    
            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }
    
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'The given data was invalid.',
                    'errors' => [
                        'password' => [
                            'Invalid credentials'
                        ],
                    ]
                ], Response::HTTP_NOT_FOUND);
            }
    
            $user = User::where('email', $request->email)->first();
            
            $authToken = $user->createToken('auth-token')->plainTextToken;
    
            return response()->json([
                'data' => $user,
                'access_token' => $authToken,                
            ], Response::HTTP_OK);
        }
        catch(\Exception $e)
        {  	        			
          Log::critical(" Error al hace login: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
        } 
        
       
    }

    public function logout(Request $request)
    {
        try{
            $request->user()->currentAccessToken()->delete();
        return response()->json([
            'data' => $request->user(),
            'message' => "Token deleted successfully!",
        ], Response::HTTP_OK);
        }
        catch(\Exception $e)
        {  	        			
          Log::critical(" Error al hace logout: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
        } 		
               
    }
}
