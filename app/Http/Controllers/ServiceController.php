<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-servicios|crear-servicios|editar-servicios|borrar-servicios',['only'=>['index']]);
        $this->middleware('permission:crear-servicios',['only'=>['create','store']]);
        $this->middleware('permission:editar-servicios',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-servicios',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios = Service::paginate(5);
        return view('servicios.index',compact('servicios'));
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
        return view('servicios.crear',compact('oficinas'));
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
            'bar_code' => 'required',
            'name' => 'required',
            'cost' => 'required',
            'price' => 'required',
            'description' => 'required',
            'office_id' => 'required',
        ]);

        Service::create($request->all());
        return redirect()->route('servicios.index');
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
        $servicio = Service::find($id);
        $oficinas = Office::join('businesses','businesses.id','=','offices.business_id')
        ->select(DB::raw("CONCAT(offices.name, ' - ',businesses.name) AS name"),'offices.id')->pluck('name','id');
        return view('servicios.editar',compact('servicio','oficinas'));
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
            'bar_code' => 'required',
            'name' => 'required',
            'cost' => 'required',
            'price' => 'required',
            'description' => 'required',
            'office_id' => 'required',
        ]);

        $servicio = Service::find($id);
        $servicio->update($request->all());
        return redirect()->route('servicios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $servicio = Service::find($id);
        $servicio->delete();
        return redirect()->route('servicios.index');
    }
}
