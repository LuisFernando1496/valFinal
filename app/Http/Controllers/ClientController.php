<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Client;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-clientes|crear-clientes|editar-clientes|borrar-clientes',['only'=>['index']]);
        $this->middleware('permission:crear-clientes',['only'=>['create','store']]);
        $this->middleware('permission:editar-clientes',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-clientes',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Client::paginate(5);
        return view('clientes.index',compact('clientes'));
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
        return view('clientes.crear',compact('oficinas'));
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
            'name' => 'required',
            'last_name' => 'required',
            'second_last_name' => 'required',
            'phone' => 'required|unique:clients,phone',
            'email' => 'required|unique:clients,email',
            'rfc' => 'required|unique:clients,rfc',
            'curp' => 'required|unique:clients,curp',
            'date' => 'required',
            'office_id' => 'required',
           // 'number' => 'required'
        ]);
        try {
            DB::beginTransaction();
            $address = new Address();
            $address->street = $request->street;
            $address->number = $request->exterior;
            $address->suburb = $request->suburb;
            $address->postal_code = $request->postal_code;
            $address->city = $request->city;
            $address->state = $request->state;
            $address->country = $request->country;
            $address->save();
            $request['address_id'] = $address->id;
            Client::create($request->all());
            DB::commit();
            return redirect()->route('clientes.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
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
        $oficinas = Office::join('businesses','businesses.id','=','offices.business_id')
        ->select(DB::raw("CONCAT(offices.name, ' - ',businesses.name) AS name"),'offices.id')->pluck('name','id');
        $cliente = Client::find($id);
        return view('clientes.editar',compact('oficinas','cliente'));
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
            'name' => 'required',
            'last_name' => 'required',
            'second_last_name' => 'required',
            'phone' => 'required|unique:clients,phone,'.$id,
            'email' => 'required|unique:clients,email,'.$id,
            'rfc' => 'required|unique:clients,rfc,'.$id,
            'curp' => 'required|unique:clients,curp,'.$id,
            'date' => 'required',
            'office_id' => 'required'
        ]);
        $cliente = Client::find($id);
        $address = Address::find($cliente->address_id);
        $address->update([
            'street' => $request->street,
            'number' => $request->exterior,
            'suburb' => $request->suburb,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country
        ]);
        $cliente->update($request->all());
        return redirect()->route('clientes.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Client::find($id);
        $cliente->delete();
        return redirect()->route('clientes.index');
    }
}
