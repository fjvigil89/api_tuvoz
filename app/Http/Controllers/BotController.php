<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\User;
use Log;
class BotController extends Controller
{
     
    static function sendBotMessenger(String $msg)
    {
        try {

            $python ="python3";
            $script = $python." ".public_path()."/modelo/botIA.py ".$msg;
            $output = shell_exec($script); //No se ejecuta
            return $output;
        } catch (\Exception $e) {
            Log::critical(" Error en el envio del bot: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
        }
    }

      
}
