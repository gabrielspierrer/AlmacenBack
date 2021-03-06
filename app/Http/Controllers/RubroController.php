<?php

namespace App\Http\Controllers;

use App\Rubro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RubroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get de rubros ordenados por id descendente
        $rubro = Rubro::orderBy('id', 'desc')->get();
        return $rubro;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        // Verificar campos de rubros antes de hacer el post
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
        ]);
        
        if ($validator->fails()) {
            $validar = false;
            $validacion = $validator->errors();
            $validacion->add('validar', $validar);
            return $validacion;
        }else {
            $validar = true;
            $rubro = Rubro::create($request->all());
            $rubro['validar'] = $validar;
            return $rubro;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rubro  $rubro
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get por id de rubros
        return Rubro::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rubro  $rubro
     * @return \Illuminate\Http\Response
     */
    public function edit(Rubro $rubro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rubro  $rubro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Verificar campos antes de hacer el put
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
        ]);
        
        if ($validator->fails()) {
            $validar = false;
            $validacion = $validator->errors();
            $validacion->add('validar', $validar);
            return $validacion;
        }else {
            $validar = true;
            $rubro = Rubro::findOrFail($id);
            $rubro->update($request->all());
            $rubro['validar'] = $validar;
            return $rubro;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rubro  $rubro
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete de rubros
        $rubro = Rubro::findOrFail($id);
        $rubro->delete();
    }
}