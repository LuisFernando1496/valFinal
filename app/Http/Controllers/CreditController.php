<?php

namespace App\Http\Controllers;


use App\Models\Client;
use App\Models\Credit;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\SaleHasCredit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class CreditController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-creditos|crear-creditos|editar-creditos|borrar-creditos',['only'=>['index']]);
        $this->middleware('permission:crear-creditos',['only'=>['create','store']]);
        $this->middleware('permission:editar-creditos',['only'=>['edit','update']]);
        $this->middleware('permission:borrar-creditos',['only'=>['destroy']]);
    }
    public function index()
    {
        $user = Auth()->user();
        $creditos = getDataModels($user, Credit::class);
        return view('creditos.index',compact('creditos'));
    }

    public function historialCompras(Client $client)
    {
        $clientShop = Sale::where('client_id',$client->id)->with('payments')->orderBy('id','DESC')->paginate(5);
    // return $clientShop;
        return view('creditos.comprasClientes',compact('clientShop','client'));
      
    }

    public function abonoCredit(Request $request, $id)
    {
        $payment = Payment::where('sale_id',$id)->orderBy('id','DESC')->first();
        $clientCredit = Credit::where('client_id',$payment->client_id)->first();
        $newAvailable = $clientCredit->available + $request->amount; 
       
        
        try {
            DB::beginTransaction();
            if($request->amount > $payment->remaining){
               
                return redirect()->route('historyShop',$clientCredit)->with('mensaje','El monto introducido excede el restante');
            }
            else{
               
                 $abono = Payment::create([
                    'amount' => $request->amount,
                    'remaining' => $payment->remaining - $request->amount,
                     'sale_id' => $payment->sale_id,
                     'client_id' => $payment->client_id
                 ]);
                 $clientCredit->update([
                    'available' => $newAvailable
                 ]);
            } 
             
             DB::commit();
          
             $venta = Sale::where('client_id',$clientCredit->id)->with('payments')->first();
            return view('creditos.comprobanteAbono',compact('venta'));

            return redirect()->route('historyShop',$clientCredit)->with('mensaje','El abono se a realisado conexito');
          
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
       
    }

    public function comprobante($id)
    {
        $venta = Sale::where('id',$id)->with('payments')->first();
       // return $venta;
        return view('creditos.comprobanteFinal',compact('venta'));
    }

    public function create()
    {
        $user = auth()->user();
        $clientes = getDataModels($user, Client::class);
        return view('creditos.crear', compact('clientes'));
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
            'amount' => 'required|numeric',
        ]);
        try {
            DB::beginTransaction();
            $request['available'] = $request->amount;
            Credit::create($request->all());
            DB::commit();
            return redirect()->route('creditos.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
       
    }

    public function details($id)
    {
        $venta = Sale::where('id',$id)->with('payments')->first();
        // return $venta;
        return view('creditos.detailsAbono',compact('venta'));
    }

    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $credito = Credit::find($id);
        $user = auth()->user(); 
        $clientes = getDataModels($user, Client::class);
        return view('creditos.editar',compact('credito','clientes'));
    }

    
    public function update(Request $request,$id)
    {
        $credit = Credit::find($id);
        try{
            DB::beginTransaction();
            $credit->update($request->all());
            DB::commit();
            return redirect()->route('creditos.index')->with('mensaje','Credito editado con exito!!');
        }
        catch(\Throwable $th){
            DB::rollBack();
            return redirect()->route('creditos.index')->with('mensaje',"Nose pudo editar el credito error: $th !!");;
        };
      
    }

   
    public function destroy($id)
    {
        $credit = Credit::find($id);
        try{
            DB::beginTransaction();
            $credit->delete();
            DB::commit();
            return redirect()->route('creditos.index')->with('mensaje','Credito eliminado con exito!!');
        }
        catch(\Throwable $th){
            DB::rollBack();
            return redirect()->route('creditos.index')->with('mensaje',"Nose pudo eliminar el credito error: $th !!");;
        };
    }
}
