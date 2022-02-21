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
            $python ="python3";
            $script = $python." ".public_path()."/modelo/botIA.py ".$request->msg;
            $output = shell_exec($script); //No se ejecuta
            return response()->json([
                'data' => $output,
                'message' => 'The data was found successfully.',
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::critical(" Error en el envio del bot: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
        }
    }

      
}
