<?php

namespace App\Http\Controllers;

use App\VentaCompra;
use App\Comprobante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class VentaCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventaCompra = VentaCompra::with('articulo')->get();
        return $ventaCompra;
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
            'articulo_id' => 'required',
            'cantidad' => 'required|numeric|gt:0',
            'precio' => 'required',
        ]);
        
        if ($validator->fails()) {
            $validar = false;
            $validacion = $validator->errors();
            $validacion->add('validar', $validar);
            return $validacion;
        }else {
            $validar = true;
            $ventaCompra = VentaCompra::create($request->all());
            $ventaCompra['validar'] = $validar;
            return $ventaCompra;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VentaCompra  $ventaCompra
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ventaCompra = VentaCompra::with('articulo')->find($id);
        return $ventaCompra;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VentaCompra  $ventaCompra
     * @return \Illuminate\Http\Response
     */
    public function edit(VentaCompra $ventaCompra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VentaCompra  $ventaCompra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VentaCompra $ventaCompra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VentaCompra  $ventaCompra
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ventaCompra = VentaCompra::findOrFail($id);
        $ventaCompra->delete();
    }

    public function ventacompra($tipo)
    {
        DB::beginTransaction();
        try {
            $ventaCompra = VentaCompra::with('articulo')->get();
            $numero = uniqid();
            $total = $ventaCompra->sum('precio');
            $comprobante = Comprobante::create([
                'fecha' => now(),
                'numero' => $numero,
                'tipo' => $tipo,
                'total' => $total,
            ]);

            $comprobanteDetalle = array();
            for ($i = 0; $i < count($ventaCompra); $i++) {
                $comprobanteDetalle[$i] = $comprobante->comprobantedetalles()->create([
                    'comprobante_id' => $comprobante->id,
                    'articulo' =>  $ventaCompra[$i]->articulo['nombre'],
                    'cantidad' => $ventaCompra[$i]->cantidad,
                    'precio' => $ventaCompra[$i]->precio,
                ]);
            }    

            DB::table('venta_compras')->delete();

            DB::commit();

            $respuesta = true;
            $comprobante['respuesta'] = $respuesta;
            return $comprobante;

        } catch (\Exception $e) {    
            
            DB::rollback();

            $respuesta = false;
            return $respuesta;
            throw $e;
        }
    }

    public function borrar()
    {
        DB::table('venta_compras')->delete();
    }
}
