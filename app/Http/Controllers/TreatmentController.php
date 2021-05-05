<?php

namespace App\Http\Controllers;

use App\Treatment;
use App\Phrase;
use App\Record;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TreatmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = Auth::user();
        $treatment=Treatment::where('user_id', $user->id)->get();
        if (!$treatment) {
            return response()->json([
                'message' => 'The given data was not found.',
            ], Response::HTTP_NOT_FOUND);
        }        
        
        return response()->json([
            'data' => $treatment,
            'message' => 'The data was found successfully.',
        ], Response::HTTP_OK);

        
    }

    public function countTreatment()
    {
        //
        $user = Auth::user();
        $treatment=Treatment::where('user_id', $user->id)->get();
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $treatment = new Treatment;
        if($request->has('name'))
        {
            $treatment->name = $request->name;
            

        }
        else{ return response("No ha entrado el nombre del Tratamiento", 300); }
        if($request->has('desc'))
        {
            $treatment->desc = $request->desc;

        }
        else{ return response("No ha entrado la descripción del Tratamiento", 300); }
        
        

        if($request->hasFile('file'))
        {
          //obtenemos el campo file definido en el formulario
            $file = $request->file('file');

            $validator = Validator::make($request->all(), [
                'file' => 'required|file|mimes:mp3,jpeg',

            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator);
            }
           
            if($this->saveAudio($file))
            {
                $record = new Record;
                $record->path = $request->root()."/storage/audio/".$file->getClientOriginalName();
                $record->name = $file->getClientOriginalName();
                $record->save();
                
                $treatment->Record()->associate($record->id);
                
                
            }
              
        }
        ///aqui debe ser un array o lista para asocialo al tratamiento
        if($request->has('phrase'))
        {
            $phrase = new Phrase;
            $phrase->phrase = $request->phrase;
            $phrase->save();

            $treatment->Phrase()->associate($phrase->id);
            
            

        }

        $treatment->save();

        return response()->json($treatment, 200);
         
    }

    function saveAudio($file)
    {
        try{       
            //obtenemos el nombre del archivo
            $nombre = $file->getClientOriginalName();
            
            //indicamos que queremos guardar un nuevo archivo en el disco local
            \Storage::disk('audio')->put($nombre,  \File::get($file));
            return true;
        }
        catch(\Exception $e)
        {
            Log::critical("The file is not save :{$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            return false;
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
                return response("No existe el Tratamiento deseado", 404);
            }            
            return response()->json($item, 200);
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
        //
        //
        try{
            $item = Treatment::FindOrFail($treatment);
            if (!$item) {
                return response("No existe el Tratamiento deseado", 404);
            }

            
            $item_phrase = Phrase::FindOrFail($item->Phrase->id);

            if ($item_phrase) {
                $item_phrase->delete();
            }

            $item_record = Record::FindOrFail($item->Record->id);
            if ($item_record) {
                $item_record->delete();
            }

            $item->delete();  

            return response()->json($item, 200);
        }
        catch(\Exception $e)
        {
            Log::critical("No existe el Tratamiento deseado :{$e->getCode()}, {$e->getLine()}, {$e->getMessage()} ");
            return response("Alguna cosa esta mal", 500);
        }

        

    }
}
