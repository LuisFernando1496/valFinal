<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CostPrice;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\VendorHasProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-productos|crear-productos|editar-productos|borrar-productos',['only'=>['index']]);
        $this->middleware('permission:crear-productos',['only'=>['create','store']]);
        $this->middleware('permission:editar-productos',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-productos',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Product::paginate(5);
        return view('productos.index',compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors = Vendor::join('offices','offices.id','=','vendors.office_id')
        ->select(DB::raw("CONCAT(vendors.name, ' - ',offices.name) AS name"),'vendors.id')->pluck('name','id');
        $categorias = Category::join('offices','offices.id','=','categories.office_id')->select(DB::raw(
            "CONCAT(categories.name, ' - ',offices.name) AS name"
        ),'categories.id')->pluck('name','id');
        return view('productos.crear',compact('vendors','categorias'));
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
            'mark' => 'required',
            'vendor_id' => 'required',
            'category_id' => 'required',
            'stock' => 'required'
        ]);
        try {
            DB::beginTransaction();
            $product = new Product();
            $product->bar_code = $request['bar_code'];
            $product->name = $request['name'];
            $product->description = $request['description'];
            $product->mark = $request['mark'];
            $product->category_id = $request['category_id'];
            $product->save();
            $request['product_id'] = $product->id;
            VendorHasProduct::create($request->all());
            DB::commit();
            return redirect()->route('productos.index');
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
        $producto = Product::find($id);
        $vendors = Vendor::join('offices','offices.id','=','vendors.office_id')
        ->select(DB::raw("CONCAT(vendors.name, ' - ',offices.name) AS name"),'vendors.id')->pluck('name','id');
        $vendor = Vendor::find($producto->vendor[0]->vendor_id);
        return view('productos.editar',compact('producto','vendors','vendor'));
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
            'mark' => 'required',
            'vendor_id' => 'required',
            'category_id' => 'required',
            'stock' => 'required'
        ]);
        try {
            DB::beginTransaction();
            $producto = Product::find($id);
            $producto->update([
                'bar_code' => $request->bar_code,
                'name' => $request->name,
                'description' => $request->description,
                'mark' => $request->mark,
                'category_id' => $request->category_id
            ]);
            $request['product_id'] = $producto->id;
            $vendorproduct = VendorHasProduct::find($producto->vendor[0]->id);
            $vendorproduct->update($request->all());
            DB::commit();
            return redirect()->route('productos.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $producto = Product::find($id);
        $producto->delete();
        return redirect()->route('productos.index');
    }

    public function costosver($id)
    {
        $vendorproduct = VendorHasProduct::find($id);
        $producto = Product::find($vendorproduct->product_id);
        $costos = CostPrice::where('vendor_product_id','=',$id)->paginate(5);
        return view('costos.index',compact('costos','producto'));
    }

    public function costoscrear($id)
    {
        $vendorproduct = VendorHasProduct::find($id);
        $producto = Product::find($vendorproduct->product_id);
        return view('costos.crear',compact('vendorproduct','producto'));
    }

    public function costospost(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'cost' => 'required',
            'price' => 'required',
            'vendor_product_id' => 'required'
        ]);

        CostPrice::create($request->all());
        return redirect()->route('productos.index');
    }

    public function costosedit($id)
    {
        $costo = CostPrice::find($id);
        $vendorproduct = VendorHasProduct::find($costo->vendor_product_id);
        $producto = Product::find($vendorproduct->product_id);
        return view('costos.editar',compact('costo','producto','vendorproduct'));
    }

    public function costosupdate(Request $request,$id)
    {
        $costo = CostPrice::find($id);
        $costo->update($request->all());
        return redirect()->route('productos.index');
    }

    public function costosdelete($id)
    {
        $costo = CostPrice::find($id);
        $costo->delete();
        return redirect()->route('productos.index');
    }

    public function search($busqueda)
    {
        $productos = Product::where('bar_code','LIKE',"%$busqueda%")->orWhere('name','LIKE',"%$busqueda%")->get();
        return response()->json([
            'status' => 200,
            'data' => $productos
        ]);
    }
}
