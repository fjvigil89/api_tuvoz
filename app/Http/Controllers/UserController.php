<?php

namespace App\Http\Controllers;

use App\DeviceModel;
use App\LocationModel;
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

use function PHPUnit\Framework\isNull;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/user",
     *     tags={"Usuarios"},
     *     summary="Todo los Usuarios",
     *     description="Todos los Ususarios Solo para el Super Admin",
     *     operationId="index",
     *     deprecated=false,     
     *     @OA\Response(
     *         response=200,
     *         description="Resultado con éxito"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalido el resultado"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )     
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $user = User::all();
            if (!$user) {
                return response()->json([
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            }
            foreach ($user as $key => $item)
            {
                $user[$key]['location']= LocationModel::where('user_id', $item->id)->first();
            }
            return response()->json([
                'data' => $user,
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::critical(" Error al cargar los Usuarios: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllpatient()
    {
        //
        try {
            $user = Auth::user();
            $patients = User::where('specialist_id', $user->id)->get();
            if (!$patients) {
                return response()->json([
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            }
            foreach ($patients as $key => $patient) {
                $user_treatment = User_Treatment::where('patient_id', $patient->id)->get();
                $countTreatmentByPatient = count($user_treatment);                
                $countTreatmentByPatientComplete = 0;
                foreach ($user_treatment as $treat) {
                    if ($treat->complete === 1) {
                        $countTreatmentByPatientComplete ++;
                    }                    
                }

                $patient['porcientoTreatmentComplete'] = $this->obtenerPorcentaje($countTreatmentByPatientComplete, $countTreatmentByPatient );                
                
            }



            return response()->json([
                'data' => $patients,
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::critical(" Error al cargar los Paciente: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
        }
    }

    function obtenerPorcentaje($current, $total) {
        if ($total > 0) {
            $total = (float)$total; 
            $porcentaje = ((float)$current * 100) / $total; 
            $porcentaje = round($porcentaje, 2);
            return $porcentaje;
        }        
        return 0;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getPatientNotTreatment(Request $request)
    {
        try {
            $user = Auth::user();
            $patients = User::where('specialist_id', $user->id)->get();
            $notTreatment = array();

            foreach ($patients as $item) {
                $patient = User_Treatment::where('patient_id', $item->id)->where('treatment_id', $request->idTreatment)->first();
                if (is_null($patient)) {
                    array_push($notTreatment, $item);
                }
            }

            return response()->json([
                'data' =>  $notTreatment,
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::critical(" Error al cargar los Paciente: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function associatePatientTreatment(Request $request)
    {

        try {
            $phrase = Phrase::where('treatment_id', $request->idTreatment)->first();
            $user = User_Treatment::create([
                'patient_id'      => $request->idPatient,
                'treatment_id'    => $request->idTreatment,
                'current_phrase'  => $phrase->id,
                'created_at'      => date('Y-m-d H:m:s'),
                'updated_at'      => date('Y-m-d H:m:s')
            ]);

            if (!$user) {
                return response()->json([
                    'data' => FALSE,
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'data' =>  TRUE,
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::critical(" Error al cargar los Paciente: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
        }
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function RecordByUser()
    {
        //
        try {
            $user = Auth::user();
            //$user = User::find(2);
            $treatment = Treatment::where('specialist_id', $user->id)->get();
            if (!$treatment) {
                return response()->json([
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            }
            $recordList = array();            
            foreach ($treatment as $item) {               
                $phrases = Phrase::where('treatment_id', $item->id)->get();
                foreach($phrases as $key => $phrase)
                {                    
                    $record = Record::where('phrase_id', $phrase->id)->get();                                          
                    foreach($record as $voice){
                        array_push($recordList, $voice);                                                
                        $recordList[$key]['phrase_id'] = $phrase;
                        $recordList[$key]['phrase_id']['treatment_id'] = $item;
                        $recordList[$key]['devices'] = DeviceModel::where("record_id", $voice->id)->first();
                                
                    }
                    
                }
                
            }            
            return $recordList;
                
        } catch (\Exception $e) {
            Log::critical(" Error al cargar las Voces: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecordByUser()
    {
                
        return response()->json([
            'data' => $this->RecordByUser(),
            'message' => 'The data was found successfully.',
        ], Response::HTTP_OK);
      
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function countGetRecordByUser()
    {        
        return response()->json([
            'data' => count($this->RecordByUser()),
            'message' => 'The data was found successfully.',
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        try {
            $user = User::find($user);
            if (!$user) {
                return response()->json([
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'data' => $user,
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::critical(" Error al cargar los Usuarios: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $item = User::FindOrFail($id);
            if (!$item) {
                return response()->json([                    
                    'message' => 'No se ha encontrado el archivo.',
                ], Response::HTTP_NOT_FOUND); 
            }

         
                $item->delete();
                 
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