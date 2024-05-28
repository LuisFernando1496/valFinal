<?php

namespace App\Http\Controllers;

use App\Models\CostPrice;
use App\Models\Credit;
use App\Models\Expense;
use App\Models\ExpenseHasSale;
use App\Models\ExpenseHasSaleHasCostPrice;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleHasCostPrice;
use App\Models\SaleHasCredit;
use App\Models\SaleHasService;
use App\Models\UserHasCashRegister;
use App\Models\UserHasCashRegisterHasCostPrice;
use App\Models\VendorHasProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-ventas|crear-ventas|editar-ventas|borrar-ventas',['only'=>['index','show']]);
        $this->middleware('permission:crear-ventas',['only'=>['create','store']]);
        $this->middleware('permission:editar-ventas',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-ventas',['only'=>['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ventas = Sale::where('status',true)->paginate(5);
        return view('ventas.index',compact('ventas'));
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
        $idventa = 0;
        $cajauser = UserHasCashRegister::find($request->user_cash_id);
        $today = date("Y-m-d");
        $metodo = $request->method;
        $client = $request->client_id;
        $usercash = $request->user_cash_id;
        $abono = $request->abono;
        $total = $request->total;
        $descuento = $request->discount;
        $porcentaje = $request->percent;
        $modo = $request->modo;
        $re = '/\b(\w)[^\s]*\s*/m';
        $str = $cajauser->cashregister->office->business->name;
        $subst = '$1';
        $negocio = preg_replace($re, $subst, $str);
        $re2 = '/\b(\w)[^\s]*\s*/m';
        $str2 = $cajauser->cashregister->office->name;
        $subst2 = '$1';
        $oficina = preg_replace($re2, $subst2, $str2);
        $ventas = Sale::join('user_has_cash_registers','user_has_cash_registers.id','=','sales.user_cash_id')
        ->join('cash_registers','cash_registers.id','=','user_has_cash_registers.cash_register_id')
        ->join('offices','offices.id','=','cash_registers.office_id')->select('sales.*')->where('offices.id','=',$cajauser->cashregister->office->id)->get();
        $numventa = sizeof($ventas) + 1;
        $folio = $negocio . "/".$oficina . "-" . $numventa;
        try {
            DB::beginTransaction();
            if ($modo != "Credito") {
                $carrito = UserHasCashRegisterHasCostPrice::where('user_cash_id','=',$usercash)->get();
                if ($client != "general") {
                    $venta = new Sale();
                    $venta->folio = $folio;
                    $venta->date = $today;
                    $venta->total = $total;
                    $venta->discount = $descuento;
                    $venta->percent = $porcentaje;
                    $venta->method = $metodo;
                    $venta->client_id = $client;
                    $venta->user_cash_id = $usercash;
                    $venta->save();
                    $idventa = $venta->id;
                    foreach ($carrito as $item) {
                        if ($item->cost_price_id != null) {
                            $saleitem = new SaleHasCostPrice();
                            $saleitem->sale_id = $venta->id;
                            $saleitem->cost_price_id = $item->cost_price_id;
                            $saleitem->quantity = $item->quantity;
                            $saleitem->discount = $item->discount;
                            $saleitem->percent = $item->percent;
                            $saleitem->save();
                            $costprice = CostPrice::find($item->cost_price_id);
                            $vendorproduct = VendorHasProduct::find($costprice->vendor_product_id);
                            $vendorproduct->update([
                                'stock' => $vendorproduct->stock - $item->quantity,
                            ]);
                            $item->delete();
                        } else {
                            $saleservice = new SaleHasService();
                            $saleservice->sale_id = $venta->id;
                            $saleservice->service_id = $item->service_id;
                            $saleservice->quantity = $item->quantity;
                            $saleservice->discount = $item->discount;
                            $saleservice->percent = $item->percent;
                            $saleservice->save();
                            $item->delete();
                        }
                    }
                } else {
                    $venta = new Sale();
                    $venta->folio = $folio;
                    $venta->date = $today;
                    $venta->total = $total;
                    $venta->discount = $descuento;
                    $venta->percent = $porcentaje;
                    $venta->method = $metodo;
                    $venta->cliente = "Cliente en General";
                    $venta->user_cash_id = $usercash;
                    $venta->save();
                    $idventa = $venta->id;
                    foreach ($carrito as $item) {
                        if ($item->cost_price_id != null) {
                            $saleitem = new SaleHasCostPrice();
                            $saleitem->sale_id = $venta->id;
                            $saleitem->cost_price_id = $item->cost_price_id;
                            $saleitem->quantity = $item->quantity;
                            $saleitem->discount = $item->discount;
                            $saleitem->percent = $item->percent;
                            $saleitem->save();
                            $costprice = CostPrice::find($item->cost_price_id);
                            $vendorproduct = VendorHasProduct::find($costprice->vendor_product_id);
                            $vendorproduct->update([
                                'stock' => $vendorproduct->stock - $item->quantity,
                            ]);
                            $item->delete();
                        } else {
                            $saleservice = new SaleHasService();
                            $saleservice->sale_id = $venta->id;
                            $saleservice->service_id = $item->service_id;
                            $saleservice->quantity = $item->quantity;
                            $saleservice->discount = $item->discount;
                            $saleservice->percent = $item->percent;
                            $saleservice->save();
                            $item->delete();
                        }
                    }
                }
            } else {
                $carrito = UserHasCashRegisterHasCostPrice::where('user_cash_id','=',$usercash)->get();
                if ($client != "general") {
                    $credito = Credit::where('client_id','=',$client)->first();
                    if (!empty($credito)) {
                        if ($total <= $credito->available) {
                            $venta = new Sale();
                            $venta->folio = $folio;
                            $venta->date = $today;
                            $venta->total = $total;
                            $venta->discount = $descuento;
                            $venta->percent = $porcentaje;
                            $venta->method = "Credito";
                            $venta->client_id = $client;
                            $venta->user_cash_id = $usercash;
                            $venta->save();
                            $idventa = $venta->id;
                            $salecredit = new SaleHasCredit();
                            $salecredit->sale_id = $venta->id;
                            $salecredit->credit_id = $credito->id;
                            $salecredit->save();
                            $credito->update([
                                'available' => $credito->available - $total,
                            ]);
                            $pago = new Payment();
                            $pago->amount = $abono;
                            $pago->remaining = $total - $abono;
                            $pago->sale_id = $venta->id;
                            $pago->client_id = $venta->client_id;
                            $pago->save();
                            foreach ($carrito as $item) {
                                if ($item->cost_price_id != null) {
                                    $saleitem = new SaleHasCostPrice();
                                    $saleitem->sale_id = $venta->id;
                                    $saleitem->cost_price_id = $item->cost_price_id;
                                    $saleitem->quantity = $item->quantity;
                                    $saleitem->discount = $item->discount;
                                    $saleitem->percent = $item->percent;
                                    $saleitem->save();
                                    $costprice = CostPrice::find($item->cost_price_id);
                                    $vendorproduct = VendorHasProduct::find($costprice->vendor_product_id);
                                    $vendorproduct->update([
                                        'stock' => $vendorproduct->stock - $item->quantity,
                                    ]);
                                    $item->delete();
                                } else {
                                    $saleservice = new SaleHasService();
                                    $saleservice->sale_id = $venta->id;
                                    $saleservice->service_id = $item->service_id;
                                    $saleservice->quantity = $item->quantity;
                                    $saleservice->discount = $item->discount;
                                    $saleservice->percent = $item->percent;
                                    $saleservice->save();
                                    $item->delete();
                                }
                            }

                        } else {
                            return response()->json([
                                'status' => 500,
                                'mensaje' => 'Cliente sin fondos disponibles'
                            ]);
                        }
                    } else {
                        return response()->json([
                            'status' => 501,
                            'mensaje' => 'Cliente sin credito autorizado'
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 500,
                        'mensaje' => 'Para realizar una venta a credito debe seleccionar un cliente'
                    ]);
                }
            }
            if ($metodo == "Efectivo") {
                $cajauser->update([
                    'amount' => $cajauser->amount + $total
                ]);
            }
            DB::commit();
            return response()->json([
                'status' => 200,
                'id' => $idventa,
                'mensaje' => 'Todo bien'
            ]);
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
        $venta = Sale::find($id);
        return view('ventas.detalles',compact('venta'));
    }

    public function ticket($id)
    {
        $venta = Sale::find($id);
        return view('ventas.ticket',compact('venta'));
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
        $venta = Sale::find($id);
        $total = 0;
        foreach ($venta->produs as $produ) {
            $subtotal = $produ->quantity  * $produ->costprice->price;
            $total += $subtotal - $produ->discount;
        }
        $today = date('Y-m-d');
        $gasto = new Expense();
        $gasto->title = "Cancelacion";
        $gasto->description = "Devolucion de productos de la venta con folio " . $venta->folio;
        $gasto->total = $total;
        $gasto->date = $today;
        $gasto->user_id = Auth::user()->id;
        $gasto->save();

        $salegasto = new ExpenseHasSale();
        $salegasto->expense_id = $gasto->id;
        $salegasto->sale_id = $id;
        $salegasto->save();

        foreach ($venta->produs as $produ) {
            ExpenseHasSaleHasCostPrice::create([
                'expense_id' => $gasto->id,
                'sale_has_cost_price_id' => $produ->id
            ]);
            $producto = VendorHasProduct::find($produ->costprice->vendorproduct->id);
            $producto->update([
                'stock' => $producto->stock + $produ->quantity
            ]);
        }
        if ($venta->method == "Efectivo") {
            $caja = UserHasCashRegister::find($venta->user_cash_id);
            $caja->update([
                'amount' => $caja->amount - $total,
            ]);
        }
        $venta->update([
            'status' => false
        ]);
        return redirect()->route('ventas.index');

    }
}
