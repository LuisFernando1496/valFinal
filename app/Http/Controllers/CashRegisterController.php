<?php

namespace App\Http\Controllers;

use App\Models\CashRegister;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CashRegisterController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-cajas|crear-cajas|editar-cajas|borrar-cajas',['only'=>['index']]);
        $this->middleware('permission:crear-cajas',['only'=>['create','store']]);
        $this->middleware('permission:editar-cajas',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-cajas',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cajas = CashRegister::paginate(5);
        return view('boxes.index',compact('cajas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $oficinas = Office::join('businesses','businesses.id','=','offices.business_id')
        ->select(DB::raw("CONCAT(offices.name, ' - ',businesses.name) AS name"),'offices.id')->pluck('name','id');
        return view('boxes.crear',compact('oficinas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'number' => 'required',
            'starting_amount' => 'required',
            'office_id' => 'required'
        ]);
        CashRegister::create($request->all());
        return redirect()->route('boxes.index');
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
        $caja = CashRegister::find($id);
        $oficinas = Office::join('businesses','businesses.id','=','offices.business_id')
        ->select(DB::raw("CONCAT(offices.name, ' - ',businesses.name) AS name"),'offices.id')->pluck('name','id');
        return view('boxes.editar',compact('caja','oficinas'));
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
        $this->validate($request,[
            'number' => 'required',
            'starting_amount' => 'required',
            'office_id' => 'required'
        ]);

        $caja = CashRegister::find($id);
        $caja->update($request->all());
        return redirect()->route('boxes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $caja = CashRegister::find($id);
        $caja->delete();
        return redirect()->route('boxes.index');
    }
}
