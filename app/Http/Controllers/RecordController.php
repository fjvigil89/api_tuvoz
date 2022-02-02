<?php

namespace App\Http\Controllers;

use App\Treatment;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


use App\User_Treatment;
use App\Phrase;
use App\Record;
use App\User;
use App\DeviceModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Float_;
use Ramsey\Uuid\Type\Integer;

class RecordController extends Controller
{
    protected $count_features=5;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function modelOpenSmille($path)
    {
        try {
            $path= public_path()."/audio/".$path;
            $count_features =$this->count_features;        
            //$python ="C:\Users\fjvigil\AppData\Local\Programs\Python\Python38\python.exe";
            $python ="python3";
            $script = $python." ".public_path()."/modelo/openSmall.py ".$count_features." " .$path. "2>&1";
        
            //dd($script);
            $output = shell_exec($script);
            if ($output != null) {
                $split = explode("'", $output);
                $aux=explode('"',$split[1]);
                $label=array();
                $data=array();
                foreach($aux as $item)
                if (strlen($item) >3) {
                    array_push($label, $item);
                }
                $aux=explode(",",explode("]",explode('[',$split[3])[1])[0]);
                foreach($aux as $item)       
                    array_push($data,(Float)$item);       
           
    
                $label=['','','','',''];                       
                return response()->json([            
                    'label' =>$label,
                    'data' => $data,
                    'message' => 'The data was found successfully.',
                    'status' => Response::HTTP_OK,
                ], Response::HTTP_OK);    
            }
            $label=['','','','',''];
            $data =[0, 0, 0 , 0 , 0 ];        
            return response()->json([            
                'label' =>$label,
                'data' => $data,
                'message' => 'The data was found successfully.',
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::critical("OpenSmille not worker :code:{$e->getCode()}, line: {$e->getLine()}, msg:{$e->getMessage()} ");
            return false;
        }
    }

    public function lastOpenSmille()
    {
       
        try {
            $user = Auth::user();
            $audio= Record::where('identificador',$user->identificador)->get()->last();
            if($audio)
            {
                $path= public_path()."/audio/".$user->username.$audio->name;
                $count_features =$this->count_features;

                //$python ="C:\Users\fjvigil\AppData\Local\Programs\Python\Python38\python.exe";
                $python ="python3";
                $script = $python." ".public_path()."/modelo/openSmall.py ".$count_features." " .$path. "2>&1";
            
                //dd($script);
                $output = shell_exec($script); //No se ejecuta
                if ($output != null) {            
                    $split = explode("'", $output);
                    $aux=explode('"',$split[1]);
                    $label=array();
                    $data=array();
                    foreach($aux as $item)
                    if (strlen($item) >3) {
                        array_push($label, $item);
                    }
                    $aux=explode(",",explode("]",explode('[',$split[3])[1])[0]);
                    foreach($aux as $item)       
                        array_push($data,round((Float)$item, 2,PHP_ROUND_HALF_UP));       
               
    
                    $label=['','','','',''];
                    
                    return response()->json([            
                        'label' =>$label,
                        'data' => $data,
                        'message' => 'The data was found successfully.',
                        'status' => Response::HTTP_OK,
                    ], Response::HTTP_OK);
                }
                
            }
            $label=['','','','',''];
            $data =[0, 0, 0 , 0 , 0 ];        
            return response()->json([            
                'label' =>$label,
                'data' => $data,
                'message' => 'The data was found successfully.',
                'status' => Response::HTTP_OK,
            ], Response::HTTP_OK);
            
        } catch (\Exception $e) {
            Log::critical("Last OpenSmille not worker : code:{$e->getCode()}, line: {$e->getLine()}, msg:{$e->getMessage()} ");
            return false;
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
        //return response()->json($request, 200);    
        try {    
            
            $user = Auth::user();

            $identificador = $user->username.$request->identificador;
            if ($this->saveAudio($_FILES['audio'], $identificador)) {
                $record = new Record;
                $record->path = $request->root()."/audio/".$identificador;
                $record->name = $request->identificador;
                $record->identificador = $user->identificador;
                //$record->save();
                
              
                
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
                           
                            $user_treat= User_Treatment::where('treatment_id', $request->idTreatment)->where('patient_id', $user->id)->first();

                            if ($key != count($phrases)-1)
                            {
                                $tmp = Phrase::find($phrases[++$key]->id );
                                $tmp->current=TRUE;
                                $tmp->save();

                                
                                $user_treat->current_phrase=$tmp->id;
                                $user_treat->save();

                                
                            }
                            else
                            {   
                                $user_treat->complete=TRUE;
                                $user_treat->save();
                            }
                            
                        }
                }

                $this->storeDevice($record->id, $request);


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

    public function storeDevice($record_id, $request)
    {
        $device = new DeviceModel();

        $device->isDevice = $request->isDevice ? TRUE : FALSE;
        $device->brand = $request->brand;
        $device->manufacturer = $request->manufacturer;
        $device->modelName = $request->modelName;
        $device->modelId = $request->modelId;
        $device->designName = $request->designName;
        $device->productName = $request->productName;
        $device->deviceYearClass = $request->deviceYearClass;
        $device->totalMemory = $request->totalMemory;
        $device->supportedCpuArchitectures = $request->supportedCpuArchitectures;
        $device->osName = $request->osName;
        $device->osVersion = $request->osVersion;
        $device->osBuildId = $request->osBuildId;
        $device->osInternalBuildId = $request->osInternalBuildId;
        $device->osBuildFingerprint = $request->osBuildFingerprint;
        $device->platformApiLevel = $request->platformApiLevel;
        $device->deviceName = $request->deviceName;

        $device->record_id = $record_id;

        $device->save();
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