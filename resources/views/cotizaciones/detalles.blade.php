@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Detalle de venta - {{ $cotizacion->folio }} - {{ $cotizacion->date   }}</h3>
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
                                            <h5 class="card-title">Productos - Servicios</h5>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-hover mt-2">
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
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
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
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <a href="{{ route('cotizaciones.index') }}" class="btn btn-warning">Regresar</a>
                                <a href="{{ route('cotizaciones.edit',$cotizacion->id) }}" class="btn btn-success">Vender</a>
                                <a href="{{ route('cotizaciones.imprimir',$cotizacion->id) }}" class="btn btn-dark" target="blank">Imprimir</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

