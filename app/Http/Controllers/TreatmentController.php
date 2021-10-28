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

class TreatmentController extends Controller
{
    //Solo muestra los tratamientos del especialista logueado
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */    
    public function index()
    {
        //Solo muestra los tratamientos del especialista logueadov
        try{
            $user = Auth::user();
            $treatment=Treatment::where('specialist_id', $user->id)->get();            
            
            if (!$treatment) {
                return response()->json([
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            }        
                        
            foreach($treatment as $item)
            {
                $user_treatment = array();            
                $patients = User_Treatment::where('treatment_id', $item->id)->get();  
                $countTreatment = count($patients);                              
                $countTreatmentComplete = 0;
                 foreach($patients as $patient){
                     if($patient->complete === 1){
                         $countTreatmentComplete++;
                     }                  
                     array_push($user_treatment, User::where('id', $patient->patient_id)->get());
                 }
                 $item['patients'] = $user_treatment;
                 $item['porcientoTreatmentComplete'] = $this->obtenerPorcentaje($countTreatmentComplete, $countTreatment );
                 

            }
            
            return response()->json([
                'data' => $treatment,                              
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        }
        catch(\Exception $e)
            {  	        			
                Log::critical(" Error al cargar los Tratamiento: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            } 

        
    }

     //Solo muestra los tratamientos del usuario logueado
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */    
    public function countUserByTreatment()
    {
        try{
            $user = Auth::user();
            $userCurrent=User::where('specialist_id', $user->id)->get();
            $userAll=User::all();
            
            if (!$userCurrent) {
                return response()->json([
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            }        
            // $count =0;            
            // foreach($treatment as $item)
            // {
            //     $count += count(User_Treatment::where('treatment_id', $item->id)->get());
            // }
            
            return response()->json([
                'data' => count($userCurrent),
                'porcent' => $this->obtenerPorcentaje(count($userCurrent), count($userAll)),
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        }
        catch(\Exception $e)
            {  	        			
                Log::critical(" Error al cargar los Tratamiento: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
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

    public function ChangeStatus(Request $request)
    {
        try{
                //$treatment=Treatment::where('id', $request->id)->first();
                //$treatment->status != $treatment->status;                
                return response()->json([
                    'data' => $request,                              
                    'message' => 'The data was found successfully.',
                ], Response::HTTP_OK);
        }
        catch(\Exception $e)
            {  	        			
                Log::critical(" Error al cambiar el estado del Tratamiento: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            }       
    }
   
    public function countTreatment()
    {
        //
        $user = Auth::user();
        $treatmentCurrent=Treatment::where('specialist_id', $user->id)->get();
        $treatmentAll=Treatment::all();
        if (!$treatmentCurrent) {
            return response()->json([
                'message' => 'The given data was not found.',
            ], Response::HTTP_NOT_FOUND);
        }        
        
        return response()->json([
            'data' => count($treatmentCurrent),
            'porcent' => $this->obtenerPorcentaje(count($treatmentCurrent), count($treatmentAll)),
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
        try{
            $user = Auth::user();
            $treatment = new Treatment;
            if($request->has('name'))
            {
                $treatment->name = $request->name;
                

            }
            else{
                return response()->json([                    
                    'message' => 'The data descriptions were not found correctly.',
                ], Response::HTTP_NOT_FOUND);                 
            }
            if($request->has('desc'))
            {
                $treatment->desc = $request->desc;

            }
            else{ 
                return response()->json([                    
                    'message' => 'The data descriptions were not found correctly.',
                ], Response::HTTP_NOT_FOUND); }
            
            $treatment->status=true;
            
            $treatment->specialist_id = $user->id;        

            $treatment->save();
            
            
            //Relaciones con las frases
            if($request->has('phrase'))
            {
                $phrases = $request->phrase;                
                 foreach($phrases as $item)                    
                    {
                        $split = explode("\n", $item['namePhrase']);
                        foreach($split as $key => $value)
                        { 
                            $newPhrase = Phrase::create([
                                'phrase' => $value,
                                'treatment_id'=> $treatment->id,
                                'current' => $key == 0 ? 1 : 0,
                                'created_at' => date('Y-m-d H:m:s'),
                                'updated_at' => date('Y-m-d H:m:s')
                            ]);
                        }                        
                        
                    }
                
            }
            else{ 
                return response()->json([                    
                    'message' => 'The data descriptions were not found correctly.',
                ], Response::HTTP_NOT_FOUND); 
            }

            //$treatment->save();
            
            return response()->json([
                'data' => $treatment,
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
            
        }
        catch(\Exception $e)
            {  	        			
                Log::critical(" Error al adicionar Tratamiento: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            } 
         
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function show($treatment)
    {
     
        //return view('treatment.show', compact('treatment'));
        //
        try{
            $item = Treatment::find($treatment);
            if (!$item) {
                return response()->json([                    
                    'message' => 'The data descriptions were not found correctly.',
                ], Response::HTTP_NOT_FOUND); 
            }            
            return response()->json([
                'data' => $item,
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        }
        catch(\Exception $e)
        {
            Log::critical("No existe el Tratamiento deseado :{$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            return response("Alguna cosa esta mal", 500);
        }

    }

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Treatment $treatment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function destroy($treatment)
    {
        try{
            $item = Treatment::FindOrFail($treatment);
            if (!$item) {
                return response()->json([                    
                    'message' => 'The data treatment was found successfully.',
                ], Response::HTTP_NOT_FOUND); 
            }

            $item->delete();  
                        
            return response()->json([
                'data' => $item,
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        }
        catch(\Exception $e)
        {
            Log::critical("No existe el Tratamiento deseado :{$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            
        }

        

    }
}