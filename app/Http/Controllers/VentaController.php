<?php

namespace App\Http\Controllers;

use App\Venta;
use App\Comprobante;
use App\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get de ventas con su relacion articulo
        $venta = Venta::with('articulo')->get();
        return $venta;
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
        // Traer articulo especifico
        $art = Articulo::find($request->articulo_id);

        // Verificar los campos antes de hacer el post
        $validator = Validator::make($request->all(), [
            'articulo_id' => 'required|exists:articulos,id',
            'cantidad' => 'required|numeric|gt:0|lte:'.$art['stock'],
        ]);
        
        if ($validator->fails()) {
            $validar = false;
            $validacion = $validator->errors();
            $validacion->add('validar', $validar);
            return $validacion;
        }else {
            $validar = true;
            // Crear venta con el precio de venta
            $venta = Venta::create([
                'articulo_id' => $request->articulo_id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $art['precio_venta'],
                'importe' => $art['precio_venta'] * $request->cantidad,
            ]);
            $venta['validar'] = $validar;
            return $venta;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get por id de ventas con relacion articulo
        $venta = Venta::with('articulo')->find($id);
        return $venta;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete de ventas
        $venta = Venta::findOrFail($id);
        $venta->delete();
    }

    public function venta()
    {
        DB::beginTransaction();
        try {
            // Crear comprobante de la venta
            $venta = Venta::with('articulo')->get();
            $tipo = 'Venta';
            $total = $venta->sum('importe');
            $comprobante = Comprobante::create([
                'fecha' => now(),
                'hora' => now(),
                'tipo' => $tipo,
                'total' => $total,
            ]);

            // Crear los detalles del comprobante
            $comprobanteDetalle = array();
            for ($i = 0; $i < count($venta); $i++) {
                $comprobanteDetalle[$i] = $comprobante->comprobantedetalles()->create([
                    'comprobante_id' => $comprobante->id,
                    'articulo_id' =>  $venta[$i]->articulo['id'],
                    'cantidad' => $venta[$i]->cantidad,
                    'precio_unitario' => $venta[$i]->precio_unitario,
                    'importe' => $venta[$i]->importe,
                ]);
            }

            // Restar la cantidad del stock en los articulos
            $articulos = Articulo::all();
            for ($i = 0; $i < count($articulos); $i++) {
                for ($j = 0; $j < count($comprobanteDetalle); $j++) {
                    if ($articulos[$i]->id == $comprobanteDetalle[$j]->articulo_id) {
                        $articulos[$i]->update([
                            'stock' => $articulos[$i]->stock - $comprobanteDetalle[$j]->cantidad,
                        ]);
                    }
                }
            }

            // Eliminar de la tabla de ventas
            DB::table('ventas')->delete();

            DB::commit();

            $respuesta = true;
            return $respuesta;

        } catch (\Exception $e) {    
            
            DB::rollback();

            $respuesta = false;
            return $respuesta;
            throw $e;
        }
    }

    public function sumaVenta() {
        // Calcular el total de todas las ventas del dia
        $comprobantes = Comprobante::all();
        $fecha = now()->toDateString('Y-m-d');
        $sumaTotal = 0;

        for ($i = 0; $i < count($comprobantes); $i++) {
            if ($comprobantes[$i]->tipo == 'Venta' && $comprobantes[$i]->fecha == $fecha) {
                $sumaTotal += $comprobantes[$i]->total;
            }
        }

        return $sumaTotal;
    }
}