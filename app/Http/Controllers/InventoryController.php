<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-inventario|crear-inventario|editar-inventario|borrar-inventario',['only'=>['index','show']]);
        $this->middleware('permission:crear-inventario',['only'=>['create','store']]);
        $this->middleware('permission:editar-inventario',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-inventario',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $categorias = Category::where('business_id','=',$user->office->business->id)->paginate(5);
        return view('inventario.index',compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $categorias = Category::join('offices','offices.id','=','categories.office_id')
        ->join('businesses','businesses.id','=','offices.business_id')->select(
            DB::raw("CONCAT(categories.name, ' - ',offices.name) AS name"),'categories.id'
        )->where('businesses.id','=',$id)->pluck('name','id');
        $almacen = Warehouse::find($id);
        return view('inventario.crear',compact('categorias','almacen'));
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
            'description' => 'required',
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'mark' => 'required',
            'category_id' => 'required',
            'warehouse_id' => 'required'
        ]);
        Inventory::create($request->all());
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $inventarios = Inventory::where('warehouse_id','=',$id)->paginate(5);
        $almacen = Warehouse::find($id);
        return view('inventario.index',compact('inventarios','almacen'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventario = Inventory::find($id);
        $categorias = Category::join('offices','offices.id','=','categories.office_id')
        ->join('businesses','businesses.id','=','offices.business_id')->select(
            DB::raw("CONCAT(categories.name, ' - ',offices.name) AS name"),'categories.id'
        )->where('businesses.id','=',$inventario->warehouse->business_id)->pluck('name','id');
        $almacen = Warehouse::find($inventario->warehouse_id);
        return view('inventario.editar',compact('inventario','categorias','almacen'));
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
            'description' => 'required',
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'mark' => 'required',
            'category_id' => 'required',
            'warehouse_id' => 'required'
        ]);
        $inventario = Inventory::find($id);
        $inventario->update($request->all());
        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventario = Inventory::find($id);
        $inventario->delete();
        return redirect()->route('home');
    }
}
