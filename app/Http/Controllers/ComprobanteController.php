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
        $comprobante = Comprobante::findOrFail($id);
        $comprobante->delete();
    }
}
