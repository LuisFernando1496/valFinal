<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Expense;
use App\Models\Office;
use App\Models\Sale;
use App\Models\Transfer;
use App\Models\User;
use App\Models\VendorHasProduct;
use App\Models\Warehouse;
use DateTime;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sucursales = Office::all();
        $usuarios = User::all();
        $almacenes = Warehouse::all();
        $clientes = Client::all();
        return view('reports.index',compact('sucursales','usuarios','almacenes','clientes'));
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
        //return $request;
        $fechaI = $request->dateI;
        $fechaF = $request->dateF;
        switch ($request->type) {
            case 'General':
                $transferencias = Transfer::whereBetween('created_at',[$fechaI,$fechaF])->get();
                return $transferencias;
                $productos = VendorHasProduct::whereBetween('updated_at',[$fechaI,$fechaF])->get();
                $ventas = Sale::whereBetween('created_at',[$fechaI,$fechaF])->get();
                $compras = Expense::whereBetween('created_at',[$fechaI,$fechaF])->get();
                $clientes = Client::whereBetween('created_at',[$fechaI,$fechaF])->get();
                break;
            case 'Sucursales':
                # code...
                break;
            case 'Almacen':
                # code...
                break;
            case 'Inventario':
                # code...
                break;
            case 'Clientes':
                # code...
                break;
            case 'Personal':
                # code...
                break;
            case 'Servicios':
                # code...
                break;
            case 'Ventas':
                # code...
                break;
            default:
                # code...
                break;
        }

        switch ($request->metodo) {
            case 'imprimir':
                return view('reports.general',compact('transferencias','productos','ventas','compras','clientes'));
                break;
            case 'pdf':
                break;
            case 'excel':
                break;
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
