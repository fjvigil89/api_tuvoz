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


class TreatmentPatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $user = Auth::user();
            $use_treatment=User_Treatment::where('patient_id', $user->id)->get();
            
            if (!$use_treatment) {
                return response()->json([
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            }        
            $treatment_patient = array();
            foreach($use_treatment as $item)
            {   
                $treatment = Treatment::where('id', $item->treatment_id)->first();
                $treatment['specialist']= User::where('id', $treatment->specialist_id)->first();
                
                array_push($treatment_patient, $treatment);                
            }
            
            return response()->json([
                'data' => $treatment_patient,                              
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        }
        catch(\Exception $e)
            {  	        			
                Log::critical(" Error al cargar los Tratamiento: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            } 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function countPatientTreatment()
    {
        //
        $user = Auth::user();
        $treatment=User_Treatment::where('patient_id', $user->id)->get();
        if (!$treatment) {
            return response()->json([
                'message' => 'The given data was not found.',
            ], Response::HTTP_NOT_FOUND);
        }        
        
        return response()->json([
            'data' => count($treatment),
            'message' => 'The data was found successfully.',
        ], Response::HTTP_OK);

        
    }
    
     /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function phrasePatientTreatment($treatment)
    {
               
        $user = Auth::user();   
        $phrase=Phrase::where('treatment_id', $treatment)->get();
        $use_treatment= User_Treatment::where('treatment_id', $treatment)->where('patient_id', $user->id)->first();

        if (!$phrase) {
            return response()->json([
                'message' => 'The given data was not found.',
            ], Response::HTTP_NOT_FOUND);
        }      
        foreach($phrase as $item)
        {
            $item['current_phrase'] = $use_treatment->current_phrase;
        }  
        
        
        return response()->json([
            'data' => $phrase,
            'message' => 'The data was found successfully.',
        ], Response::HTTP_OK);

        
    }

    

   
}