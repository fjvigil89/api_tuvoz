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

class UserController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllpatient()
    {
        //
        try{
            $user = Auth::user();
            $patient=User::where('specialist_id', $user->id)->get();

            return response()->json([
                'data' => $patient,                              
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        }
        catch(\Exception $e)
            {  	        			
                Log::critical(" Error al cargar los Paciente: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            } 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getPatientNotTreatment(Request $request)
    {        
        try{
             $user = Auth::user();
             $patients=User::where('specialist_id', $user->id)->get();            
             $notTreatment=array();
             
             foreach($patients as $item)
             {
                $patient= User_Treatment::where('patient_id', $item->id)->where('treatment_id', $request->idTreatment)->first();
                if(is_null($patient))
                {
                    array_push($notTreatment, $item);                        
                }
             }

            return response()->json([
                'data' =>  $notTreatment,
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        }
        catch(\Exception $e)
            {  	        			
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
        
        try{
             $user = User_Treatment::create([                    
                'patient_id'   => $request->idPatient,
                'treatment_id'   => $request->idTreatment,
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
        }
        catch(\Exception $e)
            {  	        			
                Log::critical(" Error al cargar los Paciente: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
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
    public function destroy(User $user)
    {
        //
    }
}
