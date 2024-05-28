<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cotizacion {{ $cotizacion->folio }}</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>

<body>
    <div class="container">
        <div class="card mt-2">
            <div class="row g-0">
                <div class="col-md-6">
                    <img src="{{ asset('img/logo.png') }}" class="img-fluid rounded-start" alt="..." style="max-width: 100%">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h5 class="card-title">Cotizacion {{ $cotizacion->folio }}</h5>
                        <p class="card-text">{{ $cotizacion->usercash->cashregister->office->street }} #{{ $cotizacion->usercash->cashregister->office->number }}, {{ $cotizacion->usercash->cashregister->office->suburb }}, {{ $cotizacion->usercash->cashregister->office->postal_code }}, {{ $cotizacion->usercash->cashregister->office->city }} {{ $cotizacion->usercash->cashregister->office->state }}, {{ $cotizacion->usercash->cashregister->office->country }}<br></p>
                        <p>Atendido por: <b>{{ $cotizacion->usercash->user->name }} {{ $cotizacion->usercash->user->last_name }}</b></p>
                        <p>Fecha: <b>{{ $cotizacion->date }}</b></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <h5 class="card-title">Productos/Servicios</h5>
            </div>
            @php
                $subtotalg = 0;
            @endphp
            <div class="card-body">
                <table class="table table-striped mt-2">
                    <thead style="background-color: #6777ef;">
                        <th style="display: none;">ID</th>
                        <th style="color: #fff;">Producto/Servicio</th>
                        <th style="color: #fff;">Costo</th>
                        <th style="color: #fff;">Precio</th>
                        <th style="color: #fff;">Cantidad</th>
                        <th style="color: #fff;">Subtotal</th>
                        <th style="color: #fff;">Descuento %</th>
                        <th style="color: #fff;">Total</th>
                    </thead>
                    <tbody>
                        @forelse ($cotizacion->produs as $produ)
                            <tr>
                                <td style="display: none;">{{ $produ->id }}</td>
                                @if ($produ->cost_price_id != null)
                                    <td>{{ $produ->costprice->vendorproduct->product->name }}</td>
                                    <td>${{ $produ->costprice->cost }}</td>
                                    <td>${{ $produ->costprice->price }}</td>
                                    <td>{{ $produ->quantity }}</td>
                                    @php
                                        $subtotal = $produ->costprice->price * $produ->quantity;
                                        $total = $subtotal - $produ->discount;
                                        $subtotalg += $total;
                                    @endphp
                                    <td>${{ number_format($subtotal,2,'.',',') }}</td>
                                    <td>{{ $produ->percent }}%</td>
                                    <td>${{ number_format($total,2,'.',',') }}</td>
                                @else
                                    <td>{{ $produ->service->name }}</td>
                                    <td>${{ $produ->service->cost }}</td>
                                    <td>${{ $produ->service->price }}</td>
                                    <td>{{ $produ->quantity }}</td>
                                    @php
                                        $subtotal = $produ->service->price * $produ->quantity;
                                        $total = $subtotal - $produ->discount;
                                        $subtotalg += $total;
                                    @endphp
                                    <td>${{ number_format($subtotal,2,'.',',') }}</td>
                                    <td>{{ $produ->percent }}%</td>
                                    <td>${{ number_format($total,2,'.',',') }}</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">Sin productos comprados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-body">
                <table class="table table-striped mt-2">
                    <thead style="background-color: #6777ef">
                        <th style="color: #fff">Cliente</th>
                        <th style="color: #fff">Subtotal</th>
                        <th style="color: #fff">Descuento %</th>
                        <th style="color: #fff">Total</th>
                    </thead>
                    <tbody>
                        <td>
                            @if ($cotizacion->client_id != null)
                                {{ $cotizacion->client->name }} {{ $cotizacion->client->last_name }} {{ $cotizacion->client->second_last_name }}
                            @else
                                {{ $cotizacion->cliente }}
                            @endif
                        </td>
                        <td>${{ number_format($subtotalg,2,'.',',') }}</td>
                        <td>{{ $cotizacion->percent }}%</td>
                        <td>${{ $cotizacion->total }}</td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script>
    window.print();
    window.addEventListener("afterprint", function(event) {
        window.close()
    });
</script>

</html>
