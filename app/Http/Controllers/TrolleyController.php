<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Office;
use App\Models\Trolley;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrolleyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $warehouse = Warehouse::where('user_id','=',$user->id)->first();
        $inventarios = Inventory::all();
        $oficinas = Office::all();
        $carrito = Trolley::all();
        return view('almacen.vender',compact('inventarios','oficinas','carrito','warehouse'));
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
        $carrito = new Trolley();
        $inventario = Inventory::find($request->inventory_id);
        $carrito->warehouse_id = $request->warehouse_id;
        $carrito->inventory_id = $request->inventory_id;
        $carrito->quantity = 1;
        $carrito->percent = 0;
        $carrito->discount = 0;
        $carrito->subtotal = $inventario->price;
        $carrito->total = $inventario->price;
        $carrito->save();
        return response()->json([
            'status' => 200,
            'mensaje' => 'Todo bien'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $carrito = Trolley::find($id);
        if ($request->quantity != null) {
            $cantidad = $request->quantity;
            $porcentaje = $carrito->percent;
            $descuento = ($carrito->subtotal * $porcentaje)/100;
            $subtotal = $carrito->inventory->price * $cantidad;
            $total = $subtotal - $descuento;
            $carrito->update([
                'subtotal' => $subtotal,
                'quantity' => $cantidad,
                'total' => $total
            ]);
        } else {
            $cantidad = $carrito->quantity;
            $porcentaje = $request->percent;
            $subtotal = $carrito->subtotal;
            $descuento = ($subtotal * $porcentaje)/100;
            $total = $subtotal - $descuento;
            $carrito->update([
                'subtotal' => $subtotal,
                'percent' => $porcentaje,
                'discount' => $descuento,
                'total' => $total
            ]);
        }

        return response()->json([
            'status' => 200,
            'mensaje' => 'Todo bien'
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carrito = Trolley::find($id);
        $carrito->delete();
        return response()->json([
            'status' => 200,
            'mensaje' => 'Todo bien'
        ]);
    }
}
