<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Office;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-categoria|crear-categoria|editar-categoria|borrar-categoria',['only'=>['index']]);
        $this->middleware('permission:crear-categoria',['only'=>['create','store']]);
        $this->middleware('permission:editar-categoria',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-categoria',['only'=>['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categorias = Category::paginate(5);
        return view('categorias.index',compact('categorias'));
    }

    public function getCategorias($id)
    {
        $vendor = Vendor::find($id);

        $categorias = Category::join('offices','offices.id','=','categories.office_id')->select(DB::raw(
            "CONCAT(categories.name, ' - ',offices.name) AS name"
        ),'categories.id')->where('categories.office_id','=',$vendor->office_id)->pluck('name','id');
        return response()->json($categorias);
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
        return view('categorias.crear',compact('oficinas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'office_id' => 'required'
        ]);
        Category::create($request->all());
        return redirect()->route('categorias.index');
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
        $categoria = Category::find($id);
        $oficinas = Office::join('businesses','businesses.id','=','offices.business_id')
        ->select(DB::raw("CONCAT(offices.name, ' - ',businesses.name) AS name"),'offices.id')->pluck('name','id');
        return view('categorias.editar',compact('categoria','oficinas'));
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
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'office_id' => 'required'
        ]);
        $categoria = Category::find($id);
        $categoria->update($request->all());
        return redirect()->route('categorias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = Category::find($id);
        $categoria->delete();
        return redirect()->route('categorias.index');
    }
}
