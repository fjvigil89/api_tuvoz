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
use Illuminate\Support\Facades\Storage;
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
        //return response()->json($request, 200);    
        try {    
            
            $user = Auth::user();

            $identificador = $user->username.$request->identificador;
            if ($this->saveAudio($_FILES['audio'], $identificador)) {
                $record = new Record;
                $record->path = $request->root()."/audio/".$identificador;
                $record->name = $request->identificador;
                $record->identificador = $user->identificador;
                $record->save();
                
                
                $phrases= Phrase::all();               
                foreach($phrases as $key => $phrase)
                {
                    if ($phrase->id == $request->idPhrase)
                        {
                            $aux = Phrase::find($phrase->id );
                            if(!$aux)
                            {
                                return response()->json([
                                    'data' => FALSE,
                                    'message' => 'The data file were not found correctly.',
                                    'status' => Response::HTTP_NOT_FOUND,
                                ], Response::HTTP_NOT_FOUND);
                            }
                            $aux->current= 0;
                            $aux->save();

                            $record->phrase_id=$phrase->id;
                            $record->save();
                           
                            if ($key != count($phrases)-1)
                            {
                                $tmp = Phrase::find($phrases[++$key]->id );
                                $tmp->current=1;
                                $tmp->save();
                            }
                            else
                            {
                                
                                $user_treat= User_Treatment::where('treatment_id', $request->idTreatment)->where('patient_id', $user->id)->first();
                                $user_treat->status=1;
                                $user_treat->save();
                            }
                            
                        }
                }


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
        try{
            $item = Record::FindOrFail($id);
            if (!$item) {
                return response()->json([                    
                    'message' => 'No se ha encontrado el archivo.',
                ], Response::HTTP_NOT_FOUND); 
            }

         
             if(Storage::disk('audio')->delete($item->identificador.$item->name))
             {
                $item->delete();
             }     
            return response()->json([
                'data' => $item,
                'message' => 'Los datos se han cargado correctamente.',
            ], Response::HTTP_OK);
        }
        catch(\Exception $e)
        {
            Log::critical("No existe el audio deseado :{$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            
        }
    }
}