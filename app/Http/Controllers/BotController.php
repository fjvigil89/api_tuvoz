<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\User;
use Log;
class BotController extends Controller
{
       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendBotMessenger(Request $request)
    {
        try {

            $user = Auth::user();
            $salida=$request->msg;
            return response()->json([  
                'data' => $salida,
                'message' => 'The data was found successfully.',
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::critical(" Error en el envio del bot: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
        }
    }

      
}
