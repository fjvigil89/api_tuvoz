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
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return response()->json($request, 200);

        // try{
        //      if($request->has('record'))
        //         {
        //         //obtenemos el campo file definido en el formulario                    
        //             $name = explode("/", $request->record);
        //             $record = Record::create([
        //                 'path' => $request->record,
        //                 'name' =>$name[count($name)-1],
        //                 'phrase_id' => $request->idPhrase,
        //             ]);

        //             // if($this->saveAudio($file))
        //             // {
        //             //     $record = new Record;
        //             //     $record->path = $request->root()."/storage/audio/".$file->getClientOriginalName();
        //             //     $record->name = $file->getClientOriginalName();
        //             //     $record->save();

        //             //     $treatment->Record()->associate($record->id);
        //             // }

        //         }
        //         else{
        //             return response()->json([                    
        //                 'message' => 'The data descriptions were not found correctly.',
        //             ], Response::HTTP_NOT_FOUND); 
        //         }                   

        //     return response()->json([
        //         'data' => $record,
        //         'message' => 'The data was found successfully.',
        //     ], Response::HTTP_OK);
        // }
        // catch(\Exception $e)
        // {
        //     Log::critical("problema con la Grabación deseado :{$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");

        // }
    }

    function saveAudio($file, $identificador)
    {
        try {            
            
            //indicamos que queremos guardar un nuevo archivo en el disco local
            $path = "./audio/". $identificador;
            if (move_uploaded_file($file['tmp_name'], $path)) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::critical("The file is not save :{$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            return false;
        }
    }

    public function storeRecordFile(Request  $request)
    {             
        try {    
            
            $user = User::where("name", "Demo")->first();

            $identificador = $user->identificador.$request->identificador;
            if ($this->saveAudio($_FILES['audio'], $identificador)) {
                $record = new Record;
                $record->path = $request->root()."/audio/".$identificador;
                $record->name = $request->identificador;
                $record->identificador = $user->identificador;
                $record->save();
                
                return response()->json([
                    'data' => TRUE,
                    'message' => 'The data was found successfully.',
                    'status' => Response::HTTP_OK,
                ], Response::HTTP_OK);
            }

            return response()->json([
                'data' => FALSE,
                'message' => 'The data file were not found correctly.',
                'status' => Response::HTTP_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
