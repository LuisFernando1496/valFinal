<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>COMPROBANTE DE PAGO</title>
</head>

<body>

    <style>
        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;

        }

        }

        .left {
            margin-left: 0px;
            margin-right: auto;
            margin-top: 0%;
            padding-top: 0%;
        }

        td,
        tr,
        table {

            border-collapse: collapse;
        }

        td.cantidad,
        th.cantidad {
            word-break: break-all;
        }

        td.precio,
        th.precio {
            word-break: break-all;
        }

        .centrado {
            text-align: center;
            align-content: center;
            width: 100%;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        table.borde {

            border-collapse: collapse;
        }
        }

        @media print {

            .oculto-impresion,
            .oculto-impresion * {
                display: none !important;
            }
        }

    </style>

    <div>
        <table class="borde" style="width: 110%">
            <thead>
                <th class="borde"> <img src="{{ asset('img/logo.png') }}" alt="Logotipo"></th>
                <th>
                    <p class="centrado">
                        {{ $venta->usercash->cashregister->office->street }}
                        #{{ $venta->usercash->cashregister->office->number }},
                        {{ $venta->usercash->cashregister->office->suburb }},
                        {{ $venta->usercash->cashregister->office->postal_code }},
                        {{ $venta->usercash->cashregister->office->city }}
                        {{ $venta->usercash->cashregister->office->state }},
                        {{ $venta->usercash->cashregister->office->country }}<br>
                        Atendido por {{ $venta->usercash->user->name }} {{ $venta->usercash->user->last_name }}<br>


                    </p>
                </th>
                <th>
                    Fecha: {{ $venta->created_at->format('d-m-y h:m:s') }} <br>
                    Folio: {{ $venta->folio }} <br>
                </th>
            </thead>
        </table>
        <br>


        <section style="display: flex; justify-content: space-between; align-items: center;">
            <hr>
            <table style="width: 100%">
                <tr>
                    <thead style="font-size: 80%">
                        <th>CANTIDAD</th>
                        <th>PRODUCTO</th>
                        <th>P/U</th>
                        <th>DESCUENTO</th>

                    </thead>
                    <hr>
                </tr>
                <tbody style="text-align: center;font-size: 76%">

                    @forelse($venta->produs as $product)
                        <tr>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->costprice->vendorproduct->product->name }}</td>
                            <td>{{ $product->costprice->price }}</td>
                            <td>{{ $product->percent }}</td>


                        </tr>
                    @empty
                        <td colspan="5"> Sin productos</td>
                    @endforelse
                </tbody>
                <hr>
            </table>
        </section>
        <br>
        <br>
        <hr>
        <section style="display: flex; justify-content: space-between; align-items: center;">
            <table style="width: 100%">
                <tr>
                    <thead style="font-size: 80%">
                        <th>CANTIDAD</th>
                        <th>SERVICIO</th>
                        <th>P/U</th>
                        <th>DESCUENTO</th>

                    </thead>
                    <hr>
                </tr>
                <tbody style="text-align: center;font-size: 76%">

                    @forelse($venta->services as $servicio)
                        <tr>
                            <td>{{ $servicio->quantity }}</td>
                            <td>{{ $servicio->service->name }}</td>
                            <td>{{ $servicio->service->price }}</td>
                            <td>{{ $product->percent }}</td>

                        </tr>
                    @empty
                        <td colspan="5"> Sin productos</td>
                    @endforelse
                </tbody>
            </table>

        </section>
        <br>
        <br>
        <div id="total">

            <br>
            Total: ${{ number_format($venta->total, 2, '.', ',') }}
        </div>
        <hr>
        <section style="display: flex; justify-content: space-between; align-items: center;">
            <table style="width: 100%">
                <tr>
                    <thead style="font-size: 80%">
                        <th>ABONOS</th>
                        <th>SALDO RESTANTE</th>
                        <th> FECHA</th>

                    </thead>
                    <hr>
                </tr>
                <tbody style="text-align: center;font-size: 76%">

                    @php
                        $totalAbono = 0;
                    @endphp
                    @forelse ($venta->payments as $payment)
                        @php
                            $totalAbono += $payment->amount;
                        @endphp
                        <tr>
                            <td>${{ number_format($payment->amount, 2) }}</td>
                            <td>${{ number_format($payment->remaining, 2) }}</td>
                            <td>{{ $payment->created_at->isoFormat('lll') }}</td>

                        </tr>
                    @empty
                        <td colspan="5"> Sin productos</td>
                    @endforelse
                </tbody>
            </table>

        </section>
        <table class='table'>
            <tr>
                <td>Total Abonado ${{number_format($totalAbono,2)}} </td>
            </tr>
        </table>
        <hr />

        <div id="total">

            <br>
            PAGADO
        </div>
        <br>
        <br>

        <p class="centrado">_____________________________</p>
        <p class="centrado">Firma</p>
        <br />
        <br />
        <br />


    </div>
</body>
<script>
    window.print();
    window.addEventListener("afterprint", function(event) {
        window.close()
    });
</script>

</html>
