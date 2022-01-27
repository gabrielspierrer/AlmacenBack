<?php

namespace App\Http\Controllers;

use App\Compra;
use App\Comprobante;
use App\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get de compras con relacion articulo
        $compra = Compra::with('articulo')->get();
        return $compra;
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
            'cantidad' => 'required|numeric|gt:0',
        ]);
        
        if ($validator->fails()) {
            $validar = false;
            $validacion = $validator->errors();
            $validacion->add('validar', $validar);
            return $validacion;
        }else {
            $validar = true;
            // Crear compra con el precio de costo
            $compra = Compra::create([
                'articulo_id' => $request->articulo_id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $art['precio_costo'],
                'importe' => $art['precio_costo'] * $request->cantidad,
            ]);
            $compra['validar'] = $validar;
            return $compra;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get por id de la compra
        $compra = Compra::with('articulo')->find($id);
        return $compra;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function edit(Compra $compra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Compra $compra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Compra  $compra
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete de compras
        $compra = Compra::findOrFail($id);
        $compra->delete();
    }

    public function compra()
    {
        DB::beginTransaction();
        try {
            // Crear el comprobante de la compra
            $compra = Compra::with('articulo')->get();
            $tipo = 'Compra';
            $total = $compra->sum('importe');
            $comprobante = Comprobante::create([
                'fecha' => now(),
                'hora' => now(),
                'tipo' => $tipo,
                'total' => $total,
            ]);
            
            // Creando los detalles del comprobante
            $comprobanteDetalle = array();
            for ($i = 0; $i < count($compra); $i++) {
                $comprobanteDetalle[$i] = $comprobante->comprobantedetalles()->create([
                    'comprobante_id' => $comprobante->id,
                    'articulo_id' =>  $compra[$i]->articulo['id'],
                    'cantidad' => $compra[$i]->cantidad,
                    'precio_unitario' => $compra[$i]->precio_unitario,
                    'importe' => $compra[$i]->importe,
                ]);
            }
            
            // Sumando la cantidad al stock de articulos
            $articulos = Articulo::all();
            for ($i = 0; $i < count($articulos); $i++) {
                for ($j = 0; $j < count($comprobanteDetalle); $j++) {
                    if ($articulos[$i]->id == $comprobanteDetalle[$j]->articulo_id) {
                        $articulos[$i]->update([
                            'stock' => $articulos[$i]->stock + $comprobanteDetalle[$j]->cantidad,
                        ]);
                    }
                }
            }
            
            // Borrando los datos de la tabla
            DB::table('compras')->delete();

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

    public function sumaCompra() {
        // Calcular el total de todas las compras del dia
        $comprobantes = Comprobante::all();
        $fecha = now()->toDateString('Y-m-d');
        $sumaTotal = 0;

        for ($i = 0; $i < count($comprobantes); $i++) {
            if ($comprobantes[$i]->tipo == 'Compra' && $comprobantes[$i]->fecha == $fecha) {
                $sumaTotal += $comprobantes[$i]->total;
            }
        }

        return $sumaTotal;
    }
}