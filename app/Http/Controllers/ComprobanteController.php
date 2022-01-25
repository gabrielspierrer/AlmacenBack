<?php

namespace App\Http\Controllers;

use App\Comprobante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComprobanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get de comprobantes con la relacion comprobantedetalles y su relacion con articulo
        // Ordenados por id descendente
        $comprobante = Comprobante::with('comprobantedetalles.articulo')->orderBy('id', 'desc')->get();
        return $comprobante;
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
        // Post del comprobante
        return Comprobante::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comprobante  $comprobante
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get por id de comprobante y su relacion con comprobantedetalles y articulo
        $comprobante = Comprobante::with('comprobantedetalles.articulo')->find($id);
        return $comprobante;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comprobante  $comprobante
     * @return \Illuminate\Http\Response
     */
    public function edit(Comprobante $comprobante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comprobante  $comprobante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comprobante  $comprobante
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete de comprobantes
        $comprobante = Comprobante::findOrFail($id);
        $comprobante->delete();
    }
}