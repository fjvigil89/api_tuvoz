<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6'
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
    
            // $user = User::create([
            //     'name' => $request->name,
            //     'email' => $request->email,
            //     'password' => bcrypt($request->password),
            //     'identificador' => bcrypt($request->name),
            //     'role' => 'Guest',
            //     'specialist_id' => '1',
            // ])->assignRole('Guest');
    
    
            //$user->roles()->attach(2); // Simple user role
            //$this->login($request);
            return response()->json($request);
        } catch (\Throwable $th) {
            //throw $th;
            Log::critical(" Error al cargar los Usuarios: {$th->getCode()}, {$th->getLine()}, {$th->getMessage()} ");
        }
        
    }

    public function pre_register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'url'           => 'required',
                'identificador' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }


            User::create([
                'name' => "Nuevo Registro",
                'email' => $request->email,
                'password' => bcrypt(random_int(1, 10)),
                'identificador' => bcrypt($request->identificador),
                'role' => 'Guest',
                'specialist_id' => base64_decode($request->identificador),
                'status' => false,
            ])->assignRole('Guest');

            return redirect()->to($request->url . '/' . $request->email);
        } catch (\Exception $e) {
            Log::critical(" Error al cargar los Usuarios: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            return redirect()->back();
        }
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'status' => Response::HTTP_NOT_FOUND,
                'errors' => [
                    'password' => [
                        'Invalid credentials'
                    ],
                ]
            ], Response::HTTP_NOT_FOUND);
        }

        $user = User::where('email', $request->email)->first();
        $authToken = $user->createToken($user->name)->plainTextToken;
        $user->remember_token = $authToken;
        if (isset($request->identificador)) {
            $user->identificador = $request->identificador;
        }
        $user->save();
        return response()->json([
            'data' => Auth::user(),
            'access_token' => $authToken,
            'message' => "Congratulation!! your login es successfully.",
            'status' => Response::HTTP_OK,
        ], Response::HTTP_OK);
    }

    public function webLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'status' => Response::HTTP_NOT_FOUND,
                'errors' => [
                    'password' => [
                        'Invalid credentials'
                    ],
                ]
            ], Response::HTTP_NOT_FOUND);
        }

        $user = User::where('email', $request->email)->first();
        $authToken = $user->createToken($user->name)->plainTextToken;
        $user->remember_token = $authToken;
        if (isset($request->identificador)) {
            $user->identificador = $request->identificador;
        }
        $user->save();
        //dd($user->name);
        //return view('welcome',['users', $user]);
        return view('main')->with('users', $user);
    }


    //se pasa el id del usuario que esta loguedo
    public function logout(Request $request)
    {
        try {
            $user = Auth::user()->currentAccessToken()->delete();
            return response()->json([
                'data' => $user,
                'message' => "Token deleted successfully!",
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::critical(" Error al hace logout: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
        }
    }
}
