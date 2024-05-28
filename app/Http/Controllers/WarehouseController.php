<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-almacenes|crear-almacenes|editar-almacenes|borrar-almacenes',['only'=>['index']]);
        $this->middleware('permission:crear-almacenes',['only'=>['create','store']]);
        $this->middleware('permission:editar-almacenes',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-almacenes',['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $almacenes = Warehouse::paginate(5);
        return view('almacen.index',compact('almacenes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $negocios = Business::pluck('name','id');
        return view('almacen.crear',compact('negocios'));
    }

    public function getUser($id)
    {
        $usuarios = User::join('offices','offices.id','=','users.office_id')
        ->join('businesses','businesses.id','=','offices.business_id')
        ->select(DB::raw("CONCAT(users.name, ' ',users.last_name, ' ',users.second_last_name,' - ',offices.name) AS name"),'users.id')
        ->where('businesses.id','=',$id)->pluck('name','id');
        return response()->json($usuarios);
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
            'title' => 'required',
            'business_id' => 'required',
            'user_id' => 'required'
        ]);
        Warehouse::create($request->all());
        return redirect()->route('almacenes.index');
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

    public function vender()
    {

    }

    public function venta(Request $request)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $almacen = Warehouse::find($id);
        $negocios = Business::pluck('name','id');
        return view('almacen.editar',compact('negocios','almacen'));
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
            'title' => 'required',
            'business_id' => 'required',
            'user_id' => 'required'
        ]);

        $almacen = Warehouse::find($id);
        $almacen->update($request->all());
        return redirect()->route('almacenes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $almacen = Warehouse::find($id);
        $almacen->delete();
        return redirect()->route('almacenes.index');
    }
}
