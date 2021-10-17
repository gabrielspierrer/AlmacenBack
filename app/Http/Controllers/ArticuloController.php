<?php

namespace App\Http\Controllers;

use App\Articulo;
use App\ComprobanteDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articulo = Articulo::with('rubro')->get();
        return $articulo;
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
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'rubro_id' => 'required',
            'stock_min' => 'required',
            'stock_max' => 'required|gt:stock_min',
            'precio' => 'required|numeric|gt:0',
            'fecha_venc' => 'required',
        ]);
        
        if ($validator->fails()) {
            $validar = false;
            $validacion = $validator->errors();
            $validacion->add('validar', $validar);
            return $validacion;
        }else {
            $validar = true;
            $articulo = Articulo::create($request->all());
            $articulo['validar'] = $validar;
            return $articulo;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $articulo = Articulo::with('rubro')->find($id);
        return $articulo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function edit(Articulo $articulo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'rubro_id' => 'required',
            'stock_min' => 'required',
            'stock_max' => 'required|gt:stock_min',
            'precio' => 'required|numeric|gt:0',
            'fecha_venc' => 'required',
        ]);
        
        if ($validator->fails()) {
            $validar = false;
            $validacion = $validator->errors();
            $validacion->add('validar', $validar);
            return $validacion;
        }else {
            $validar = true;
            $articulo = Articulo::findOrFail($id);
            $articulo->update($request->all());
            $articulo['validar'] = $validar;
            return $articulo;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Articulo  $articulo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $articulo = Articulo::findOrFail($id);
        $articulo->delete();
    }

    public function inventario()
    {
        DB::beginTransaction();
        try {
            $detalles = ComprobanteDetalle::with('comprobante')->get();
            $ventaCompra = array();
            $ventaCompra = $detalles->groupBy('comprobante.tipo');

            DB::commit();

            return $ventaCompra;

        } catch (\Exception $e) {    
            
            DB::rollback();

            $respuesta = false;
            return $respuesta;
            throw $e;
        }
    }
}