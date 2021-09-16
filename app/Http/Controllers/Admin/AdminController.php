<?php

namespace App\Http\Controllers\Admin;

use App\DeviceModel;
use App\Http\Controllers\Controller;
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

class AdminController extends Controller
{
    //Solo muestra todo los Tratamientos
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */    
    public function getAllTreatment()
    {
        try{
            
            $treatment=Treatment::all();
            
            if (!$treatment) {
                return response()->json([
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            } 
            
            foreach($treatment as $item)
            {
                $item['specialist_id'] = User::where('id', $item->specialist_id)->get();

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

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */    
    public function countGetTreatment()
    {
        try{
            
            $treatment=Treatment::all();
            
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
    public function countGetUser()
    {
        try{
            
            $user=User::all();
            
            if (!$user) {
                return response()->json([
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            } 
                                              
            return response()->json([
                'data' => count($user),                              
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        }
        catch(\Exception $e)
            {  	        			
                Log::critical(" Error al cargar los usuarios: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            } 

        
    }

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */    
    public function getUser()
    {
        try{
            
            $user=User::all();
            
            if (!$user) {
                return response()->json([
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            } 
                                              
            return response()->json([
                'data' => $user,                              
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        }
        catch(\Exception $e)
            {  	        			
                Log::critical(" Error al cargar los usuarios: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            } 

        
    }

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */    
    public function countGetRecord()
    {
        try{
            
            $record=Record::all();
            
            if (!$record) {
                return response()->json([
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            } 
                                              
            return response()->json([
                'data' => count($record),                              
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        }
        catch(\Exception $e)
            {  	        			
                Log::critical(" Error al cargar los usuarios: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            } 

        
    }

    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\Http\Response
     */    
    public function getAllRecord()
    {
        try{
            
            $record=Record::all();
            
            if (!$record) {
                return response()->json([
                    'message' => 'The given data was not found.',
                ], Response::HTTP_NOT_FOUND);
            } 

            foreach ($record as $key => $item)
            {
                $device = DeviceModel::where('record_id', $item->id)->first();
                $record[$key]['devices']= $device;
            }
              
            
            return response()->json([
                'data' => $record,                              
                'message' => 'The data was found successfully.',
            ], Response::HTTP_OK);
        }
        catch(\Exception $e)
            {  	        			
                Log::critical(" Error al cargar las Voces: {$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
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

}