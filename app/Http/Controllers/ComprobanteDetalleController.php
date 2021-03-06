<?php

namespace App\Http\Controllers;

use App\ComprobanteDetalle;
use Illuminate\Http\Request;

class ComprobanteDetalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get de comprobante detalle
        return ComprobanteDetalle::all();
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
        // Post de comprobante detalle
        return ComprobanteDetalle::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ComprobanteDetalle  $comprobanteDetalle
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get por id de comprobante detalle
        return ComprobanteDetalle::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ComprobanteDetalle  $comprobanteDetalle
     * @return \Illuminate\Http\Response
     */
    public function edit(ComprobanteDetalle $comprobanteDetalle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ComprobanteDetalle  $comprobanteDetalle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ComprobanteDetalle  $comprobanteDetalle
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete de comprobante detalles
        $comprobanteDetalle = ComprobanteDetalle::findOrFail($id);
        $comprobanteDetalle->delete();
    }
}