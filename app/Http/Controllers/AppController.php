<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppModel;
use Validator;
use Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        try{
            $user =  Auth::user();
            if (!$user){
                return response()->json([
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            }      

            $app = AppModel::all();
            
            if (!$app) {
                return response()->json([
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            }      
            return response()->json([
                'data' => $app,                              
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        }
        catch(\Exception $e)
            {  	        			
                Log::critical(" Error al cargar las aplicaciones: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            } 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = "./app/". $request->name;
        if ($this->saveAudio($_FILES['files'], $path)) {
            $app = new AppModel;
            $app->name = $request->name;
            $app->url = $request->root()."/app/".$request->name;
            $app->version = "v1";
            $app->descargas = 0;
            $app->save();
            
            return response()->json([
                'data' => $app,
                'message' => 'The data was found successfully.',
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        }
    }

    function saveAudio($file, $path)
    {
        try {            
            
           
            if (move_uploaded_file($file['tmp_name'], $path)) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::critical("The file is not save :{$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            return false;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

}