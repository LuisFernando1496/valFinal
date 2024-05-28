<?php

namespace App\Http\Controllers;

use App\Models\CostPrice;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Transfer;
use App\Models\TransferInventory;
use App\Models\Trolley;
use App\Models\Vendor;
use App\Models\VendorHasProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        try {
            DB::beginTransaction();
            $transferencia = Transfer::create($request->all());
            $carrito = Trolley::where('warehouse_id','=',$request->warehouse_id)->get();
            foreach ($carrito as $item) {
                $transfer = new TransferInventory();
                $transfer->transfer_id = $transferencia->id;
                $transfer->inventory_id = $item->inventory_id;
                $transfer->quantity = $item->quantity;
                $transfer->subtotal = $item->subtotal;
                $transfer->percent = $item->percent;
                $transfer->discount = $item->discount;
                $transfer->total = $item->total;
                $transfer->date = date('Y-m-d h:i:s');
                $transfer->save();

                $producto = Product::join('categories','categories.id','=','products.category_id')
                ->join('offices','offices.id','=','categories.office_id')
                ->join('vendor_has_products','vendor_has_products.product_id','=','products.id')
                ->join('cost_prices','cost_prices.vendor_product_id','=','vendor_has_products.id')
                ->select('products.*')->where('products.bar_code','=',$item->inventory->bar_code)->where('offices.id','=',$transferencia->office_id)
                ->where('cost_prices.price','=',$item->inventory->price)
                ->first();
                if (!empty($producto)) {
                    $pro = VendorHasProduct::where('product_id','=',$producto->id)->first();
                    $pro->update([
                        'stock' => $pro->stock + $item->quantity,
                    ]);
                }
                else {
                    $produ = Product::create([
                        'bar_code' => $item->inventory->bar_code,
                        'name' => $item->inventory->name,
                        'description' => $item->inventory->description,
                        'mark' => 'Nuevo',
                        'category_id' => $item->inventory->category_id
                    ]);
                    $vendor = Vendor::where('office_id','=',$transferencia->office_id)->first();
                    $vendpro = VendorHasProduct::create([
                        'vendor_id' => $vendor->id,
                        'product_id' => $produ->id,
                        'stock' => $item->quantity
                    ]);
                    CostPrice::create([
                        'name' => 'Costo Almacen',
                        'cost' => $item->inventory->cost,
                        'price' => $item->inventory->price,
                        'vendor_product_id' => $vendpro->id
                    ]);
                }
                $inventario = Inventory::find($item->inventory->id);
                $inventario->update([
                    'stock' => $inventario->stock - $item->quantity
                ]);
                $item->delete();
            }
            DB::commit();
            return response()->json([
                'status' => 200,
                'mensaje' => 'Todo bien'
            ]);
        } catch (\Throwable $th) {
            DB::beginTransaction();
            return $th;
        }
        return response()->json($request);
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
