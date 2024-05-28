<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Business;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-oficina|crear-oficina|editar-oficina|borrar-oficina',['only'=>['index']]);
        $this->middleware('permission:crear-oficina',['only'=>['create','store']]);
        $this->middleware('permission:editar-oficina',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-oficina',['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $oficinas = Office::paginate(5);
        return view('office.index',compact('oficinas'));
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $negocios = Business::pluck('name','id')->all();
        return view('office.crear',compact('negocios'));
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
            'phone' => 'required|unique:offices,phone',
            'responsable' => 'required',
            'business_id' => 'required',
            'street' => 'required',
            'exterior' => 'required',
            'suburb' => 'required',
            'postal_code' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required'
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
            Office::create($request->all());
            DB::commit();
            return redirect()->route('sucursales.index');
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
    public function edit(Office $sucursale)
    {
        $negocios = Business::pluck('name','id')->all();
        return view('office.editar',compact('negocios','sucursale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Office $sucursale)
    {
        $phone = $request['phone'];
        if ($phone != $sucursale->phone) {
            request()->validate([
                'name' => 'required',
                'phone' => 'required|unique:offices,phone',
                'responsable' => 'required',
                'business_id' => 'required',
                'street' => 'required',
                'exterior' => 'required',
                'suburb' => 'required',
                'postal_code' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required'
            ]);
        } else {
            request()->validate([
                'name' => 'required',
                'phone' => 'required',
                'responsable' => 'required',
                'business_id' => 'required',
                'street' => 'required',
                'exterior' => 'required',
                'suburb' => 'required',
                'postal_code' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required'
            ]);
        }

        $address = Address::find($sucursale->address_id);
        $address->update([
            'street' => $request->street,
            'number' => $request->exterior,
            'suburb' => $request->suburb,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country
        ]);
        $sucursale->update($request->all());
        return redirect()->route('sucursales.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $sucursale)
    {
        $sucursale->delete();
        return redirect()->route('sucursales.index');
    }
}
