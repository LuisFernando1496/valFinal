<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver-negocio|crear-negocio|editar-negocio|borrar-negocio',['only'=>['index']]);
        $this->middleware('permission:crear-negocio',['only'=>['create','store']]);
        $this->middleware('permission:editar-negocio',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-negocio',['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $negocios = Business::paginate(5);
        return view('bussiness.index',compact('negocios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bussiness.crear');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'rfc' => 'required|unique:businesses,rfc',
            'legal_representative' => 'required',
            'number' => 'required'
        ]);

        Business::create($request->all());
        return redirect()->route('negocios.index');
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
    public function edit(Business $negocio)
    {
        return view('bussiness.editar',compact('negocio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Business $negocio)
    {
        request()->validate([
            'name' => 'required',
            'rfc' => 'unique:businesses,rfc,'.$negocio->id,
            'legal_representative' => 'required',
            'number' => 'required'
        ]);
        $business = Business::find($negocio->id);
        $business->update($request->all());
        return redirect()->route('negocios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $negocio)
    {
        $negocio->delete();
        return redirect()->route('negocios.index');
    }
}
