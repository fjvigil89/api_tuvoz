<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChatModel;
use App\User;
use Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Http\Controllers\BotController;
class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBotMessenger()
    {
        try {
            $user = Auth::user();
            //$user = User::where('id','5')->get()->first();
            $chat= ChatModel::where('user_id',$user->id)->get();
            //dd($chat);
            if(empty($chat[0]))
            {
                $chat= ChatModel::where('identificador','init')->get();
                return response()->json([   
                    'data' => $chat,
                    'bot'=> User::where('username','bot')->get()->first(),
                    'message' => 'The data was found successfully.',
                    'status' => Response::HTTP_OK,
                ], Response::HTTP_OK);
                       
            }
                
            return response()->json([   
                'data' => $chat,
                'bot'=> User::where('username','bot')->get()->first(),
                'message' => 'The data was found successfully.',
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
            
        } catch (\Exception $e) {
            Log::critical("Chat not worker : code:{$e->getCode()}, line: {$e->getLine()}, msg:{$e->getMessage()} ");
            return false;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setBotMessenger(Request $request)
    {
        try {
            $user = Auth::user();
            //$user = User::where('id','5')->get()->first();
            
            ChatModel::create([
                'identificador'=>"yo",
                'msg' => trim($request->msg),           
                'user_id'=> $user->id,
            ]);
             
            $output = BotController::sendBotMessenger($request->msg);
            ChatModel::create([
                'identificador'=>"bot",
                'msg' => trim($output),           
                'user_id'=> $user->id,
            ]);
            return $this->getBotMessenger();
            
        } catch (\Exception $e) {
            Log::critical("Chat not worker : code:{$e->getCode()}, line: {$e->getLine()}, msg:{$e->getMessage()} ");
            return false;
        }
    }

   
}
