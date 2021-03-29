<?php

namespace App\Http\Controllers;

use App\Treatment;
use Illuminate\Http\Request;
use Validator;

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
        return view('Treatment/index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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

           
           //obtenemos el nombre del archivo
           $nombre = $file->getClientOriginalName();
           

           //indicamos que queremos guardar un nuevo archivo en el disco local
           \Storage::disk('audio')->put($nombre,  \File::get($file));

           //return $request->root()."/storage/audio/".$nombre;
            return back();   
        }

        return "No ha subido ningun audio";
         
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Treatment  $treatment
     * @return \Illuminate\Http\Response
     */
    public function show(Treatment $treatment)
    {
        //
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
    public function destroy(Treatment $treatment)
    {
        //
    }
}
