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

            $this->SendEmail($user->name, $request->emailRegister);

            return response()->json([
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::critical(" Error al cargar los Usuarios: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
        }
    }

    function SendEmail($nombre, $email)
    {

    	$data = array(
			'name' => $nombre,
			'email' => $email
		  );	
	
  		Mail::send('Email.registroPrevioPatiente', $data, function ($message) use ($data) { 
  		    $message->from('frank.vigil@upr.edu.cu', 'UPRedes');
  		    //$message->sender('john@johndoe.com', 'John Doe');
  			
  		    $message->to($data['email'], $data['name']);
  		
  		    //$message->cc('john@johndoe.com', 'John Doe');
  		    //$message->bcc('john@johndoe.com', 'John Doe');
  		
  		    //$message->replyTo('john@johndoe.com', 'John Doe');
  		
  		    $message->subject('Sincronizador Automático de la UPR');
  		
  		    //$message->priority(3);
  		
  		    //$message->attach('pathToFile');
  		});
    }


    
}
