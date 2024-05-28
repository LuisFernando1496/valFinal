
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
        @php
            $subtotalgeneral = 0;
        @endphp
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
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
                                                        <th style="color: #fff;">Agregar</th>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($inventarios as $inventario)
                                                            <tr>
                                                                <td>{{ $inventario->bar_code }}</td>
                                                                <td>{{ $inventario->name }}</td>
                                                                <td>{{ $inventario->stock }}</td>
                                                                <td>${{ $inventario->price }}</td>
                                                                <td>
                                                                    <button class="btn btn-success add" type="button" data-id="{{ $inventario->id }}">Agregar</button>
                                                                </td>
                                                            </tr>
                                                        @empty

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
                                                        <th style="color: #fff">Cantidad</th>
                                                        <th style="color: #fff">Descuento %</th>
                                                        <th style="color: #fff">Total</th>
                                                        <th style="color: #fff">Eliminar</th>
                                                    </thead>
                                                    <tbody id="cuerpo">
                                                        @forelse ($carrito as $item)
                                                            <tr>
                                                                <td>{{ $item->inventory->name }}</td>
                                                                <td>{{ $item->inventory->price }}</td>
                                                                <td>
                                                                    {!! Form::number('quantity', $item->quantity, array('class' => 'form-control quantity','id' => 'quantity'.$item->id,'data-id' => $item->id, 'onChange' => 'cambiocantidad(this.value,'.$item->id.')')) !!}
                                                                </td>
                                                                <td>
                                                                    {!! Form::number('percent', $item->percent, array('class' => 'form-control percent','id' => 'percent'.$item->id,'data-id' => $item->id, 'onChange' => 'cambiopercent(this.value,'.$item->id.')')) !!}
                                                                </td>
                                                                <td>
                                                                    {!! Form::number('total', $item->total, array('class' => 'form-control','id' => 'total'.$item->id)) !!}
                                                                </td>
                                                                @php
                                                                    $subtotalgeneral += $item->total;
                                                                @endphp
                                                                <td>
                                                                    <button class="btn btn-danger quitar" data-id="{{$item->id}}" type="button">Quitar</button>
                                                                </td>
                                                            </tr>
                                                        @empty

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
                                                    <option value="Venta">Vender</option>
                                                    <option value="Cotizacion">Comprar</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3" id="sucursales">
                                            <div class="form-group">
                                                <label for="">Sucursal</label>
                                                <select name="office_id" id="office" class="form-control" required>
                                                    @forelse ($oficinas as $oficina)
                                                        <option value="{{ $oficina->id }}">{{ $oficina->name }}</option>
                                                    @empty
                                                        <option value="">Sin sucursales</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3" id="div-metodo-pay">
                                            <div class="form-group">
                                                <label for="">Metodo Pago</label>
                                                <select name="" id="metodo-pay" class="form-control">
                                                    <option value="Efectivo">Efectivo</option>
                                                    <option value="Tarjeta">Tarjeta</option>
                                                    <option value="Transferencia">Transferencia</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="divtotales">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="">Subtotal</label>
                                                    {!! Form::number('subtotal', $subtotalgeneral, array('class' => 'form-control','step' => 'any','readonly' => 'true','id' => 'subtotal')) !!}
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="">Descuento %</label>
                                                    {!! Form::number('percent', 0, array('class' => 'form-control','step' => 'any','id'=>'discount')) !!}
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="">Descuento</label>
                                                    {!! Form::number('discount', 0, array('class' => 'form-control','step' => 'any','readonly' => 'true','id' => 'descuentoprecio')) !!}
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="">Total</label>
                                                    {!! Form::number('total', $subtotalgeneral, array('class' => 'form-control','step' => 'any','readonly' => 'true','id' => 'total')) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3" id="div-pago">
                                            <div class="form-group">
                                                <label for="">Pago con:</label>
                                                {!! Form::number('pay', $subtotalgeneral, array('class' => 'form-control','step' => 'any','id' => 'pagocon')) !!}
                                            </div>
                                        </div>
                                        <div class="col-3" id="div-cambio">
                                            <div class="form-group">
                                                <label for="">Cambio</label>
                                                {!! Form::number('cambio', null, array('class' => 'form-control','step' => 'any','id'=>'cambio','readonly' => true)) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" id="warehouse" hidden value="{{ $warehouse->id }}">
                                <div class="col-xs-12 col-sm-12 col-md-12" id="divpay">
                                    <button class="btn btn-primary" type="submit" id="sell">Vender</button>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12" id="divcot">
                                    <button class="btn btn-primary" type="submit" id="buy">Comprar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $('.add').on('click',function(){
            const id = $(this).data('id');
            const warehouse = $('#warehouse').val();
            const data = {
                inventory_id: id,
                warehouse_id: warehouse
            };
            $.post('ventaalmacen',data,function(response){
                const status = response['status'];
                const mensaje = response['mensaje'];
                if (status == 200) {
                    $('#refresh').load(' #refresh');
                    $('#divtotales').load(" #divtotales");
                    alert(mensaje);
                } else {

                }
            });
        });

        function cambiocantidad(valores,ide) {
            const valor = valores;
            const id = ide;
            const data = {
                quantity : valor,
            };
            $.ajax({
                type: "PUT",
                url: "/ventaalmacen/"+id,
                data: data,
            }).then(function(response){
                const status = response['status'];
                const mensaje = response['mensaje'];
                if (status != 200) {

                }
                else {
                    $("#refresh").load(" #refresh");
                    $('#divtotales').load(" #divtotales");
                    alert(mensaje);
                }
            });
        }

        function cambiopercent(valores,ide) {
            const valor = valores;
            const id = ide;

            const data = {
                percent: valor,
            };
            $.ajax({
                type: "PUT",
                url: "/ventaalmacen/"+id,
                data: data,
            }).then(function(response){
                const status = response['status'];
                const mensaje = response['mensaje'];
                if (status != 200) {

                }
                else {
                    $("#refresh").load(" #refresh");
                    $('#divtotales').load(" #divtotales");
                    alert(mensaje);
                }
            });
        }

        $('.quitar').on('click',function(){
            const id = $(this).data('id');
            eliminar(id);
        });

        function eliminar(ide)
        {
            const id = ide;
            $.ajax({
                type: "DELETE",
                url: "/ventaalmacen/"+id,
            }).then(function(response){
                const status = response['status'];
                const mensaje = response['mensaje'];
                if (status != 200) {

                }
                else {
                    $("#refresh").load(" #refresh");
                    $('#divtotales').load(" #divtotales");
                    alert(mensaje);
                }
            });
        }

        $('#buy').attr('hidden',true);

        $('#tipo-venta').on('change',function(){
            const valor = $(this).children('option:selected').val();
            if (valor == "Venta") {
                $('#sucursales').attr('hidden',false);
                $('#sell').attr('hidden',false);
                $('#buy').attr('hidden',true);
                $('#cambio').attr('hidden',false);
            } else {
                $('#sucursales').attr('hidden',true);
                $('#sell').attr('hidden',true);
                $('#buy').attr('hidden',false);
                $('#cambio').attr('hidden',true);
            }
        });

        $('#discount').on('change',function(){
            const valor = $(this).val();
            const subtotal = $('#subtotal').val();
            const descuento = (subtotal * valor)/100;
            const total = subtotal - descuento;
            $('#descuentoprecio').val(descuento.toFixed(2));
            $('#total').val(total.toFixed(2));
            $('#pagocon').attr('min',total.toFixed(2));
            $('#pagocon').val(total.toFixed(2));
        });

        $('#metodo-pay').on('change',function(){
            const valor = $(this).children('option:selected').val();
            const total = $('#total').val();
            if (valor == "Tarjeta" || valor == "Transferencia") {
                $('#pagocon').val(total);
                $('#cambio').val(0);
            } else {
                $('#pagocon').val(0);
            }
        });

        $('#pagocon').on('change',function()
        {
            const valor = $(this).val();
            const total = $('#total').val();
            const cambio = valor - total;
            $('#cambio').val(cambio.toFixed(2));
        });

        $('#pagocon').keyup(function () {
            const valor = $(this).val();
            const total = $('#total').val();
            const cambio = valor - total;
            $('#cambio').val(cambio.toFixed(2));
        });

        $('#sell').on('click',function(){
            const data = {
                warehouse_id: $('#warehouse').val(),
                office_id: $('#office').children('option:selected').val(),
                subtotal: $('#subtotal').val(),
                percent: $('#discount').val(),
                discount: $('#descuentoprecio').val(),
                total: $('#total').val(),
                method: $('#metodo-pay').children('option:selected').val(),
                status: 'En revision'
            };
            $.post('transferencias',data,function(response){
                const status = response['status'];
                if (status == 200) {
                    location.reload();
                }
                else {
                    alert('Error');
                }
            });
        });

        $('#buy').on('click',function(){
            const data = {
                warehouse_id: $('#warehouse').val(),
                subtotal: $('#subtotal').val(),
                percent: $('#discount').val(),
                discount: $('#descuentoprecio').val(),
                total: $('#total').val(),
                method: $('#metodo-pay').children('option:selected').val(),
            };
            $.post('compras',data,function(response){
                const status = response['status'];
                console.log(response);
                if (status == 200) {
                    location.reload();
                }
                else {
                    alert('Error');
                }
            });
        });

    </script>
@endsection

