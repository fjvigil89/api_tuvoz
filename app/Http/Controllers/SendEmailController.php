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

            $this->SendEmail($user, $request);

            return response()->json([                
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::critical(" Error al cargar los Usuarios: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
        }
    }

    function SendEmail($user, $request)
    {   
    	$data = array(
			'name' => $user->nombre,
			'email' => $request->emailRegister, 
            'url_register' => $request->uri_register,
            'identificador' => base64_encode($user->id),
		  );	
	
  		Mail::send('Email.registroPrevioPatiente', $data, function ($message) use ($data) { 
  		    $message->from('no-reply@tuvoz.es', 'TuVoz');
  		    $message->to($data['email'], $data['name']);
  		    $message->subject('Registro en la plataforma TuVoz');
  		});
    }


    
}
