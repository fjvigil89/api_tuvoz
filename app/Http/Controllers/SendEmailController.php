<?php

namespace App\Http\Controllers;


use App\Treatment;
use App\User_Treatment;
use App\Phrase;
use App\Record;
use App\User;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use Log;
use Mail;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SendEmailController extends Controller
{
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setEmailRegisterPatient(Request $request)
    {
        try {
            $user = Auth::user();            
            if (!$user) {
                return response()->json([
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            }

            $this->SendEmail($user, $request, "Guest");
          
            User::create([
                'name' => "Nuevo Registro",
                'username' => explode('@',$request->emailRegister)[0],
                'email' => $request->emailRegister,
                'password' => bcrypt(random_int(1, 10)),
                'identificador' => bcrypt($request->emailRegister),
                'role' => "Guest",
                'identificador' => base64_encode($request->emailRegister),
                'status' => false,
                'foto'=> "http://lorempixel.com/grey/800/800/people/fake/",
                'specialist_id' => $user->id,
            ])->assignRole("Guest");

            return response()->json([                
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::critical(" Error al cargar los Usuarios: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
        }
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setEmailRegisterSpecialist(Request $request)
    {
        try {
            $user = Auth::user();            
            if (!$user) {
                return response()->json([
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            }

            $this->SendEmail($user, $request, "Specialist");

            return response()->json([                
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::critical(" Error al cargar los Usuarios: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
        }
    }

         /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendEmailNewApp()
    {
        try {
            $user = User::all();            
            if (!$user) {
                return response()->json([
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            }

            foreach ($user as $item)
            {
                $this->SendEmailNewAppByUser($item);
            }
            

            return response()->json([                
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::critical(" Error al cargar los Usuarios: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
        }
    }

    function SendEmail($user, $request, $role)
    {   
        
        $download = new \App\Http\Controllers\AppController();
        $aux = $download->lastUpdates();
    	$data = array(
			'name' => $user->nombre,
			'email' => $request->emailRegister, 
            'url_register' => $request->uri_register,
            'dowload_url' => $aux['url'],
            'qr_code'=> QrCode::format('png')->size(100)->generate($aux['url'], "../public/qrcode/qrcode.png"),
            'identificador' => base64_encode($user->id),
            'role' => $role,
		  );	
	
  		Mail::send('Email.registroPrevioPatiente', $data, function ($message) use ($data) { 
  		    $message->from('no-reply@tuvoz.es', 'TuVoz');
  		    $message->to($data['email'], $data['name']);
  		    $message->subject('Registro en la plataforma TuVoz');
  		});
    }

    function SendEmailNewAppByUser($user)
    {   
        
        $download = new \App\Http\Controllers\AppController();
        $aux = $download->lastUpdates();
    	$data = array(
			'name' => $user->nombre,
			'email' => $user->email,
            'dowload_url' => $aux['url'],
            'qr_code'=> QrCode::format('png')->size(100)->generate($aux['url'], "../public/qrcode/qrcode.png"),
            'identificador' => base64_encode($user->id),
            'role' => $user->role,
		  );	
	
  		Mail::send('Email.newApp', $data, function ($message) use ($data) { 
  		    $message->from('no-reply@tuvoz.es', 'TuVoz');
  		    $message->to($data['email'], $data['name']);
  		    $message->subject('Nueva versión de la App TuVoz');
  		});
    }


    
}