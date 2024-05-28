<?php

namespace App\Http\Controllers;

use App\Models\CategoryOfExpense;
use App\Models\Expense;
use App\Models\Office;
use App\Models\Owner;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{ function __construct()
    {
        $this->middleware('permission:ver-gastos|crear-gastos|editar-gastos|borrar-gastos',['only'=>['index','show']]);
        $this->middleware('permission:crear-gastos',['only'=>['create','store']]);
        $this->middleware('permission:editar-gastos',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-gastos',['only'=>['destroy']]);
    }
    public function index()
    {
        $user = Auth()->user();
        $expenses = getDataModels($user, Expense::class);  
        return view('expenses.index',compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth()->user();
        $offices = getDataModels($user, Office::class);
        $categoryExpenses = CategoryOfExpense::pluck('name','id');
        $employees = User::where('id','!=',1)->pluck('name','id');
        $owners = Owner::pluck('owner_name','id');
       // return $offices; return $categoryExpenses;
        return view('expenses.create',compact('offices','categoryExpenses','employees','owners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $date = Carbon::now();
        
        $request['date'] = $date;
        $request['user_id'] = Auth()->user()->id;
        try
        {
            DB::beginTransaction();
            $expense = Expense::create($request->all());
            DB::commit();
            return redirect()->route('expenses.index')->with('success','Gasto creado correctamente');
        }catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->route('expenses.create')->with('error','Error al guardar el gasto');
        }
      
    }

    public function vaucher(Expense $expense)
    {
       
        return view('expenses.vaucher',compact('expense'));
    }
    
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
    public function edit(Expense $expense)
    {
        $user = Auth()->user();
        $offices = getDataModels($user, Office::class);
        $categoryExpenses = CategoryOfExpense::pluck('name','id');
        return view('expenses.editar',compact('expense','offices','categoryExpenses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Expense $expense)
    {
        $date = Carbon::now();
        $request['date'] = $date;
        try
        {
            DB::beginTransaction();
            $expense->update($request->all());
            DB::commit();
            return redirect()->route('expenses.index')->with('success','Gasto actualizado correctamente');
        }catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->route('expenses.edit',$expense->id)->with('error','Error al actualizar el gasto');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
       // return $expense;
        try
        {
            DB::beginTransaction();
            $expense->update(['status'=>false]);
            DB::commit();
            return redirect()->route('expenses.index')->with('success','Gasto eliminado correctamente');
        }catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->route('expenses.index')->with('error','Error al eliminar el gasto');
        }
    }
    
}
