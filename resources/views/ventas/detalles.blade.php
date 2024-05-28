@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Detalle de venta - {{ $venta->folio }} - {{ $venta->date   }}</h3>
            @php
                $subtotalg = 0;
            @endphp
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Productos</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-hover mt-2">
                                                <thead style="background-color: #6777ef;">
                                                    <th style="display: none;">ID</th>
                                                    <th style="color: #fff;">Producto</th>
                                                    <th style="color: #fff;">Costo</th>
                                                    <th style="color: #fff;">Precio</th>
                                                    <th style="color: #fff;">Cantidad</th>
                                                    <th style="color: #fff;">Subtotal</th>
                                                    <th style="color: #fff;">Descuento %</th>
                                                    <th style="color: #fff;">Total</th>
                                                </thead>
                                                <tbody>
                                                    @forelse ($venta->produs as $produ)
                                                        <tr>
                                                            <td style="display: none;">{{ $produ->id }}</td>
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
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">Servicios</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-hover mt-2">
                                                <thead style="background-color: #6777ef;">
                                                    <th style="display: none;">ID</th>
                                                    <th style="color: #fff;">Servicio</th>
                                                    <th style="color: #fff;">Costo</th>
                                                    <th style="color: #fff;">Precio</th>
                                                    <th style="color: #fff;">Cantidad</th>
                                                    <th style="color: #fff;">Subtotal</th>
                                                    <th style="color: #fff;">Descuento %</th>
                                                    <th style="color: #fff;">Total</th>
                                                </thead>
                                                <tbody>
                                                    @forelse ($venta->services as $servicio)
                                                        <tr>
                                                            <td style="display: none;">{{ $servicio->id }}</td>
                                                            <td>{{ $servicio->service->name }}</td>
                                                            <td>${{ $servicio->service->cost }}</td>
                                                            <td>${{ $servicio->service->price }}</td>
                                                            <td>{{ $servicio->quantity }}</td>
                                                            @php
                                                                $subtotal = $servicio->service->price * $servicio->quantity;
                                                                $total = $subtotal - $servicio->discount;
                                                                $subtotalg += $total;
                                                            @endphp
                                                            <td>${{ number_format($subtotal,2,'.',',') }}</td>
                                                            <td>{{ $servicio->percent }} %</td>
                                                            <td>${{ number_format($total,2,'.',',') }}</td>
                                                        </tr>
                                                    @empty

                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <table class="table table-striped mt-2">
                                        <thead style="background-color: #6777ef">
                                            <th style="color: #fff">Cliente</th>
                                            <th style="color: #fff">Metodo</th>
                                            <th style="color: #fff">Subtotal</th>
                                            <th style="color: #fff">Descuento %</th>
                                            <th style="color: #fff">Total</th>
                                        </thead>
                                        <tbody>
                                            <td>
                                                @if ($venta->client_id != null)
                                                    {{ $venta->client->name }} {{ $venta->client->last_name }} {{ $venta->client->second_last_name }}
                                                @else
                                                    {{ $venta->cliente }}
                                                @endif
                                            </td>
                                            <td>{{ $venta->method }}</td>
                                            <td>${{ number_format($subtotalg,2,'.',',') }}</td>
                                            <td>{{ $venta->percent }}%</td>
                                            <td>${{ $venta->total }}</td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <a href="{{ route('ventas.index') }}" class="btn btn-warning">Regresar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

