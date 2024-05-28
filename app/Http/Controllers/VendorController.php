<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Office;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-proveedor|crear-proveedor|editar-proveedor|borrar-proveedor',['only'=>['index']]);
        $this->middleware('permission:crear-proveedor',['only'=>['create','store']]);
        $this->middleware('permission:editar-proveedor',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-proveedor',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::paginate(5);
        return view('proveedores.index',compact('vendors'));
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
        return view('proveedores.crear',compact('oficinas'));
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
            'phone' => 'required',
            'email' => 'required|email|unique:vendors,email',
            'office_id' => 'required',
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
            Vendor::create($request->all());
            DB::commit();
            return redirect()->route('proveedores.index');
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
        $vendor = Vendor::find($id);
        return view('proveedores.editar',compact('oficinas','vendor'));
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
        request()->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'email|unique:vendors,email,'.$id,
            'office_id' => 'required',
            'street' => 'required',
            'exterior' => 'required',
            'suburb' => 'required',
            'postal_code' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required'
        ]);
        $vendor = Vendor::find($id);
        $address = Address::find($vendor->address_id);
        $address->update([
            'street' => $request->street,
            'number' => $request->exterior,
            'suburb' => $request->suburb,
            'postal_code' => $request->postal_code,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country
        ]);
        $vendor->update($request->all());
        return redirect()->route('proveedores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vendor = Vendor::find($id);
        $vendor->delete();
        return redirect()->route('proveedores.index');
    }
}
