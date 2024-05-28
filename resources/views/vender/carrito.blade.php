
@extends('layouts.app')

@section('content')
<style>
    .tableFixHead {
        overflow-y: auto;
        height: 150px;
    }
    .tableFixHead thead th {
        position: sticky;
        top: 0;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
</style>
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Vender</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <button style="display: inline" class="btn btn-info" type="button" id="pro">Productos</button>
                            <button style="display: inline" class="btn btn-info" type="button" id="ser">Servicios</button>
                            <div class="row">
                                <div class="col" id="divpro">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="search">Busqueda Producto</label>
                                                    {!! Form::text('search', null, array('class' => 'form-control','id' => 'search','placeholder' => 'Busqueda de producto')) !!}
                                                </div>
                                            </div>
                                            <div class="tableFixHead">
                                                <table class="table table.striped mt-2">
                                                    <thead style="background-color: #6777ef;">
                                                        <th style="color: #fff;">Codigo</th>
                                                        <th style="color: #fff;">Producto</th>
                                                        <th style="color: #fff;">Stock</th>
                                                        <th style="color: #fff;">Precio</th>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($productos as $producto)
                                                            <tr>
                                                                <td>{{ $producto->bar_code }}</td>
                                                                <td>{{ $producto->name }}</td>
                                                                <td>{{ $producto->vendor[0]->stock }}</td>
                                                                <td>
                                                                    <select name="" id="costo{{ $producto->id }}" class="form-control costos">
                                                                        <option value="">Seleccionar</option>
                                                                        @forelse ($producto->vendor[0]->costos as $costo)
                                                                            <option value="{{ $costo->id }}">{{ $costo->name }} - ${{ $costo->price }}</option>
                                                                        @empty
                                                                            <option value="">Sin costos</option>
                                                                        @endforelse
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4">Sin registros</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col" id="divser">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <label for="search-service">Busqueda Servicio</label>
                                                    {!! Form::text('search-service', null, array('class' => 'form-control','id' => 'search-service','placeholder' => 'Busqueda de producto')) !!}
                                                </div>
                                            </div>
                                            <div class="tableFixHead">
                                                <table class="table table.striped mt-2">
                                                    <thead style="background-color: #6777ef;">
                                                        <th style="color: #fff;">Codigo</th>
                                                        <th style="color: #fff;">Servicio</th>
                                                        <th style="color: #fff;">Precio</th>
                                                        <th style="color: #fff;">Agregar</th>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($servicios as $servicio)
                                                            <tr>
                                                                <td>{{ $servicio->bar_code }}</td>
                                                                <td>{{ $servicio->name }}</td>
                                                                <td>${{ number_format($servicio->price,2,'.',',') }}</td>
                                                                <td>
                                                                    <button class="btn btn-success add" data-id="{{ $servicio->id }}" type="button">Agregar</button>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4">Sin registros</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="refresh" id="refresh">
                                                @php
                                                    $gtotal = 0;
                                                @endphp
                                                <table class="table table-hover mt-2" id="tablarefresh">
                                                    <thead style="background-color: #6777ef">
                                                        <th style="color: #fff">Producto</th>
                                                        <th style="color: #fff">Precio</th>
                                                        <th style="color: #fff">Marca</th>
                                                        <th style="color: #fff">Cantidad</th>
                                                        <th style="color: #fff">Descuento %</th>
                                                        <th style="color: #fff">Total</th>
                                                        <th style="color: #fff">Eliminar</th>
                                                    </thead>
                                                    <tbody id="cuerpo">
                                                        @forelse ($carrito as $item)
                                                            @if ($item->service_id != null)
                                                                @php
                                                                    $total = $item->service->price * $item->quantity;
                                                                    $gtotal += $total;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $item->service->name }}</td>
                                                                    <td>
                                                                        ${{ $item->service->price }}
                                                                        <input type="number" name="" id="precio{{$item->id}}" hidden value="{{$item->service->price}}">
                                                                    </td>
                                                                    <td>Servicio</td>
                                                                    <td>
                                                                        {!! Form::number('quantity', $item->quantity, array('class' => 'form-control quantity','id' => 'quantity'.$item->id,'data-id' => $item->id, 'onChange' => 'cambiocantidad(this.value,'.$item->id.')')) !!}
                                                                    </td>
                                                                    <td>
                                                                        {!! Form::number('percent', $item->percent, array('class' => 'form-control percent','id' => 'percent'.$item->id,'data-id' => $item->id)) !!}
                                                                    </td>
                                                                    <td>
                                                                        {!! Form::number('total', $total, array('class' => 'form-control','id' => 'total'.$item->id)) !!}
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-danger">Quitar</button>
                                                                    </td>
                                                                </tr>
                                                            @else
                                                                @php
                                                                    $total = $item->costprice->price * $item->quantity;
                                                                    $gtotal += $total;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $item->costprice->vendorproduct->product->name }}</td>
                                                                    <td>
                                                                        ${{ $item->costprice->price }}
                                                                        <input type="number" name="" id="precio{{$item->id}}" hidden value="{{$item->costprice->price}}">
                                                                    </td>
                                                                    <td>{{ $item->costprice->vendorproduct->product->mark }}</td>
                                                                    <td>
                                                                        {!! Form::number('quantity', $item->quantity, array('class' => 'form-control quantity','id' => 'quantity'.$item->id,'data-id' => $item->id, 'onChange' => 'cambiocantidad(this.value,'.$item->id.')')) !!}
                                                                    </td>
                                                                    <td>
                                                                        {!! Form::number('percent', $item->percent, array('class' => 'form-control percent','id' => 'percent'.$item->id,'data-id' => $item->id)) !!}
                                                                    </td>
                                                                    <td>
                                                                        {!! Form::number('total', $total, array('class' => 'form-control','id' => 'total'.$item->id)) !!}
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-danger">Quitar</button>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @empty
                                                            <tr>
                                                                <td colspan="7">Sin registros</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">Tipo</label>
                                                <select name="" id="tipo-venta" class="form-control">
                                                    <option value="Venta">Venta</option>
                                                    <option value="Cotizacion">Cotizacion</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">Subtotal</label>
                                                {!! Form::number('subtotal', $gtotal, array('class' => 'form-control','step' => 'any','readonly' => 'true','id' => 'subtotal')) !!}
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">Descuento %</label>
                                                {!! Form::number('percent', 0, array('class' => 'form-control','step' => 'any')) !!}
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">Descuento</label>
                                                {!! Form::number('discount', 0, array('class' => 'form-control','step' => 'any','readonly' => 'true')) !!}
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">Total</label>
                                                {!! Form::number('total', $gtotal, array('class' => 'form-control','step' => 'any','readonly' => 'true','id' => 'total')) !!}
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">Modo Pago</label>
                                                <select name="" id="" class="form-control">
                                                    <option value="Credito">Credito</option>
                                                    <option value="Una Exhibicion">Una Exhibicion</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">Metodo Pago</label>
                                                <select name="" id="" class="form-control">
                                                    <option value="Tarjeta">Tarjeta</option>
                                                    <option value="Efectivo">Efectivo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">Cliente</label>
                                                {!! Form::select('client_id', $clientes, [], array('class' => 'form-control')) !!}
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">Abono</label>
                                                {!! Form::number('abono', null, array('class' => 'form-control','step' => 'any')) !!}
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">Pago</label>
                                                {!! Form::number('pay', null, array('class' => 'form-control','step' => 'any')) !!}
                                            </div>
                                        </div>
                                        <input type="text" hidden value="{{ $usercajas->id }}" id="usercajas">
                                        <div class="col-xs-12 col-sm-12 col-md-12" id="divpay">
                                            <button class="btn btn-primary" type="submit" id="pay">Pagar</button>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-12" id="divcot">
                                            <button class="btn btn-primary" type="submit" id="coti">Cotizar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function () {
            var divpro = false;
            var divser = false;
            var cot = true;
            var pay = false;
            $('#divcot').attr('hidden',cot);
            $('#pro').on('click',function(){
                if (divpro == false) {
                    divpro = true;
                } else {
                    divpro = false;
                }

                $('#divpro').attr('hidden',divpro);
            });
            $('#ser').on('click',function(){
                if (divser == false) {
                    divser = true;
                } else {
                    divser = false;
                }

                $('#divser').attr('hidden',divser);
            });
            $('#tipo-venta').on('change', function() {
                var tipo = $(this).children("option:selected").val();
                if (tipo == "Cotizacion") {
                    cot = false;
                    pay = true;
                } else {
                    cot = true;
                    pay = false;
                }
                $('#divcot').attr('hidden',cot);
                $('#divpay').attr('hidden',pay);
            });

            $('.costos').on('change',function(){
                var id = $(this).children("option:selected").val();
                var data = {
                    user_cash_id: $('#usercajas').val(),
                    cost_price_id: id,
                    quantity: 1,
                    discount: 0,
                    percent: 0,
                };
                $.post("/vender", data,function(response){
                    console.log(response);
                    status = response['status'];
                    if (status == 200) {
                        $("#refresh").load(" #refresh");
                    }
                });
            });

            $('.add').on('click',function(){
                var id = $(this).data('id');
                var data = {
                    user_cash_id: $('#usercajas').val(),
                    service_id: id,
                    quantity: 1,
                    discount: 0,
                    percent: 0,
                };
                $.post("/vender",data,function(response){
                    console.log(response);
                    status = response['status'];
                    if (status == 200) {
                        $("#refresh").load(" #refresh");
                    }
                });
            });

            $('.quantity').on('change',function(){
                const valor = $(this).val();
                const id = $(this).data('id');
                const precio = $('#precio'+id).val();
                const total = precio * valor;
                $('#total'+id).val(total);
                $('#subtotal').val(total);
                $('#total').val(total);
                const data = {
                    quantity : valor,
                };
                $.ajax({
                    type: "PUT",
                    url: "/vender/"+id,
                    data: data,
                }).then(function(data){
                    var status = data['status'];
                    if (status != 200) {

                    }
                    else {
                        $("#refresh").load(" #refresh");

                    }
                });
            });

            $('.percent').on('change',function(){
                const valor = $(this).val();
                const id = $(this).data('id');
                const precio = $('#precio'+id).val();
                const cantidad = $('#quantity'+id).val();
                const subtotal = cantidad * precio;
                const total = subtotal - ((subtotal * valor)/100);
                $('#total'+id).val(total);
                $('#subtotal').val(total);
                $('#total').val(total);
            });



        });
        function cambiocantidad(valores,ide) {
            const valor = valores;
            const id = ide;
            const precio = $('#precio'+id).val();
            const total = precio * valor;
            $('#total'+id).val(total);
            $('#subtotal').val(total);
            $('#total').val(total);
            const data = {
                quantity : valor,
            };
            $.ajax({
                type: "PUT",
                url: "/vender/"+id,
                data: data,
            }).then(function(data){
                const status = data['status'];
                if (status != 200) {

                }
                else {
                    $("#refresh").load(" #refresh");
                }
            });
        }
    </script>
@endsection

