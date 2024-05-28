<?php

namespace App\Http\Controllers;

use App\Models\CashRegister;
use App\Models\Client;
use App\Models\Product;
use App\Models\Service;
use App\Models\UserHasCashRegister;
use App\Models\UserHasCashRegisterHasCostPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseIsSuccessful;

class SellController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-vender|crear-vender|editar-vender|borrar-vender',['only'=>['index']]);
        $this->middleware('permission:crear-vender',['only'=>['create','store']]);
        $this->middleware('permission:editar-vender',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-vender',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->getuser();
        $usercajas = UserHasCashRegister::where('user_id','=',$user->id)->first();
        $carrito = UserHasCashRegisterHasCostPrice::where('user_cash_id','=',$usercajas->id)->get();
        if ($this->roln()) {
            $user = $this->getuser();
            $productos = Product::join('vendor_has_products','vendor_has_products.product_id','=','products.id')
            ->join('vendors','vendors.id','=','vendor_has_products.vendor_id')->select('products.*')->where('vendors.office_id','=',$user->office_id)->get();
            $servicios = Service::where('office_id','=',$user->office_id)->get();
           $clientes = Client::where('office_id','=',$user->office_id)->select(DB::raw("CONCAT(clients.name,' ',clients.last_name,' ',clients.second_last_name)As name"),'clients.id')->pluck('name','id');
        }
        else {
            $productos = Product::all();
            $servicios = Service::all();
            $clientes = Client::select(DB::raw("CONCAT(clients.name,' ',clients.last_name,' ',clients.second_last_name)As name"),'clients.id')->pluck('name','id');
        }
        //return $clientes;
        return view('vender.vender',compact('usercajas','carrito','productos','user','clientes','servicios'));
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

        $this->validate($request,[
            'user_cash_id' => 'required',
        ]);
        //return request()->json($request);
        if ($request->cost_price_id == null) {
            if ($request->service_id != null) {
                $carrito = UserHasCashRegisterHasCostPrice::where('service_id','=',$request->service_id)->first();
                if (empty($carrito)) {
                    try {
                        DB::beginTransaction();
                        UserHasCashRegisterHasCostPrice::create($request->all());
                        DB::commit();
                        return response()->json([
                            'status' => 200,
                            'message' => 'Todo bien'
                        ]);
                    } catch (\Throwable $th) {
                        DB::rollBack();
                        return $th;
                    }
                } else {
                    $carrito->update([
                        'quantity' => $carrito->quantity + 1
                    ]);

                    return response()->json([
                        'status' => 200,
                        'message' => 'Todo bien'
                    ]);
                }
            }
        } else {
            if ($request->service_id == null) {
                $carrito = UserHasCashRegisterHasCostPrice::where('cost_price_id','=',$request->cost_price_id)->first();
                if (empty($carrito)) {
                    try {
                        DB::beginTransaction();
                        UserHasCashRegisterHasCostPrice::create($request->all());
                        DB::commit();
                        return response()->json([
                            'status' => 200,
                            'message' => 'Todo bien'
                        ]);
                    } catch (\Throwable $th) {
                        DB::rollBack();
                        return $th;
                    }
                } else {
                    $carrito->update([
                        'quantity' => $carrito->quantity + 1
                    ]);

                    return response()->json([
                        'status' => 200,
                        'message' => 'Todo bien'
                    ]);
                }
            }
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
        $carrito = UserHasCashRegisterHasCostPrice::find($id);
        $carrito->update($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Todo bien'
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
        $carrito = UserHasCashRegisterHasCostPrice::find($id);
        $carrito->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Todo bien'
        ]);
    }

    public function getuser()
    {
        $user = Auth::user();
        return $user;
    }

    public function roln()
    {
        $user = $this->getuser();
        if (sizeof($user->getRoleNames()) > 0) {
            return true;
        }
        else {
            return false;
        }
    }
}
