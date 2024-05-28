<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket Venta</title>
</head>
<body>

<style>
    * {
    font-size: 12px;
    font-family: 'Times New Roman';
}
td,th,tr,table {
    border-top: 1px solid black;
    border-collapse: collapse;
}
td.producto,th.producto {
    width: 150px;
    max-width: 150px;
}
td.cantidad,th.cantidad {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}
td.precio,th.precio {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}
.centrado {
    text-align: center;
    align-content: center;
    width: 100%;
}
.ticket {
    width: 155px;
    max-width: 155px;
}
img {
    max-width: inherit;
    width: inherit;
}
@media print{
  .oculto-impresion, .oculto-impresion *{
    display: none !important;
  }
}

</style>
<div class="ticket">
    <img src="{{ asset('img/logo.png') }}" alt="Logotipo">
    <p class="centrado">
        {{ $venta->usercash->cashregister->office->street }} #{{ $venta->usercash->cashregister->office->number }}, {{ $venta->usercash->cashregister->office->suburb }}, {{ $venta->usercash->cashregister->office->postal_code }}, {{ $venta->usercash->cashregister->office->city }} {{ $venta->usercash->cashregister->office->state }}, {{ $venta->usercash->cashregister->office->country }}<br>
        Atendido por {{ $venta->usercash->user->name }} {{ $venta->usercash->user->last_name }}<br>
        Fecha: {{$venta->created_at->format('d-m-y h:m:s')}} <br>
        Folio: {{$venta->folio}} <br>
        Comprobante de abono
    </p>
    @php
        $subtotalg = 0;
    @endphp
    <section id="ticket" style="display: flex; justify-content: space-between; align-items: center;">
        <div id="pro-th">CANT</div>
        <div id="pre-th">P/S  <br></div>
        <div id="cod-th">P/U</div>
        <div id="subtotal">DES</div>
        <div id="subtotal">IMP</div>
    </section>
    <hr>
    @forelse ($venta->produs as $produ)
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div id="pro-td">
                {{ $produ->quantity }}
            </div>
            <div id="pre-td" style="text-align: center;">{{ $produ->costprice->vendorproduct->product->name }}</div>
            <div id="can-td" style="text-align: center; margin-right:3px !important;">${{ $produ->costprice->price }} </div>
            <div id="can-td" style="text-align: center; margin-right:3px !important;">{{ $produ->percent }}%</div>
            @php
                $subtotal = $produ->costprice->price * $produ->quantity;
                $total = $subtotal - $produ->discount;
                $subtotalg += $total;
            @endphp
            <div id="subtotal" style="text-align: center;">${{number_format($total,2,',','.')}} </div>
        </div>
    @empty

    @endforelse
    @forelse ($venta->services as $servicio)
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <div id="pro-td">
                {{ $servicio->quantity }}
            </div>
            <div id="pre-td" style="text-align: center;">{{ $servicio->service->name }}</div>
            <div id="can-td" style="text-align: center; margin-right:3px !important;">${{ $servicio->service->price }} </div>
            <div id="can-td" style="text-align: center; margin-right:3px !important;">{{ $servicio->percent }}%</div>
            @php
                $subtotal = $servicio->service->price * $servicio->quantity;
                $total = $subtotal - $servicio->discount;
                $subtotalg += $total;
            @endphp
            <div id="subtotal" style="text-align: center;">${{number_format($total,2,',','.')}} </div>
        </div>
    @empty

    @endforelse
    <div id="total">
        Pago con {{ $venta->method }}
        =========================
        <br>
        @if($venta->percent != null)Descuento:  %{{ $venta->percent }}@endif
        =========================
        <br>
        @if($venta->discount != null)Ahorro:  ${{ $venta->discount }}@endif
        =========================
        <br>
        Total inicial: ${{number_format($venta->total,2,'.',',')}}
        =========================
        <br>
        Abono:  ${{number_format($venta->payments[0]->amount,2,'.',',')}}
        =========================
        <br>
        Saldo anterior:  ${{number_format($venta->payments[0]->amount + $venta->payments[0]->remaining,2,'.',',')}}
        =========================
        <br>
        Saldo actual: ${{number_format($venta->payments[0]->remaining,2,'.',',')}}
        {{--Pago con tarjeta : $0.00 <br>
        Descuento: $0.00 <br>
        ============ <br>
        Subtotal: ${{number_format($total,2,'.',',')}}
        ============ <br>
        Total: ${{number_format($subtotal,2,'.',',')}} <br>
        ============ <br>--}}
    </div>
    <br>
    <div class="centrado">
 <img  src="{{ asset('img/logo.png') }}" style="width: 100px; height:100px" alt="Logotipo">
    </div>

    <p class="centrado" >¡GRACIAS POR SU COMPRA!</p>
    <p class="centrado">Este ticket no es comprobante fiscal y se incluirá en la venta del día</p>
</div>
</body>
<script>
    window.print();
    window.addEventListener("afterprint", function(event) {
        window.close()
    });
</script>
</html>
