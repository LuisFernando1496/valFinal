<?php

namespace App\Http\Controllers;

use App\Models\CashRegister;
use App\Models\UserHasCashRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserCashController extends Controller
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
        $user = Auth::user();
        if (sizeof($user->getRoleNames()) > 0) {
            $cajas = CashRegister::where('office_id','=',$user->office_id)->pluck('number','id');
        }
        else {
            $cajas = CashRegister::join('offices','offices.id','=','cash_registers.office_id')
            ->select(DB::raw("CONCAT(cash_registers.number,' - ',offices.name) As number"),'cash_registers.id')->pluck('number','id');
        }
        $usercajas = UserHasCashRegister::where('user_id','=',$user->id)->where('status','=',true)->first();
        if (!empty($usercajas)) {
            return redirect()->route('vender.index');
        }
        else {
            return view('vender.index',compact('cajas','user'));
        }
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
            'user_id' => 'required',
            'cash_register_id' => 'required',
        ]);
        $request['amount'] = 0;
        $request['status'] = true;
        UserHasCashRegister::create($request->all());
        return redirect()->route('vender.index');
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
