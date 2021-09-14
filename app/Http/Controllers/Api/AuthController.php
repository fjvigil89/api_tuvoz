<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Validator;
use Log;
use App\LocationModel;
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
                'name' => 'required|min:1|max:50',
                'email' => 'required|email',
                'password' => 'required|min:6'
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
            $user = User::where('email', $request->email)->first();
            
            $user->name = $request->name;
            $user->status = TRUE;
            $user->password = bcrypt($request->password);
            
            $user->save();
    
    
            //$user->roles()->attach(2); // Simple user role
            if ($user->role === "Guest") {
                return redirect()->back();
            }
            return $this->login($request, TRUE);
            //return redirect()->to($request->redirect);
            
           //return response()->json($request);
            
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

            $user = User::where('email', $request->email)->first();
            if ($user && $user->status === 0) {
                return redirect()->to($request->url.'/'.$request->email);    
            }
            User::create([
                'name' => "Nuevo Registro",
                'username' => explode('@',$request->email)[0],
                'email' => $request->email,
                'password' => bcrypt(random_int(1, 10)),
                'identificador' => bcrypt($request->identificador),
                'role' => $request->role,
                'specialist_id' => base64_decode($request->identificador),
                'status' => false,
                'foto'=> "http://lorempixel.com/grey/800/800/people/fake/",
            ])->assignRole($request->role);

            return redirect()->to($request->url.'/'.$request->email);
        } catch (\Exception $e) {
            Log::critical(" Error al cargar los Usuarios: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            return redirect()->to($request->url);    
        }
    }

    public function login(Request $request, $newRegister = FALSE)
    {
        /* if ($request->isWeb)
            return response()->json($request, 200);
 */
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
        $device = isset($request->isWeb) ? false : false;
        //return response()->json($device, 200);
        
        if ($user->role === "Guest" && !$newRegister && $device)
        {
            $location = LocationModel::where('user_id', $user->id)->first();
            if (!$location)
            {            
                $aux = new LocationModel();
                $aux->accuracy = $request->accuracy;
                $aux->altitude = $request->altitude;
                $aux->altitudeAccuracy = $request->altitudeAccuracy;
                $aux->heading = $request->heading;
                $aux->latitude = $request->latitude;
                $aux->longitude = $request->longitude;
                $aux->speed = $request->speed;
                $aux->user_id = $user->id;
                $aux->save();
            }
            else{
                $location->accuracy = $request->accuracy;
                $location->altitude = $request->altitude;
                $location->altitudeAccuracy = $request->altitudeAccuracy;
                $location->heading = $request->heading;
                $location->latitude = $request->latitude;
                $location->longitude = $request->longitude;
                $location->speed = $request->speed;
                $location->user_id = $user->id;
                $location->save();
            }
        }
        

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