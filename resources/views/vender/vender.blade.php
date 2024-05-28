
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
                                                        <th style="color: #fff;"></th>
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
                                                                    $total = ($item->service->price * $item->quantity) - $item->discount;
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
                                                                        {!! Form::number('percent', $item->percent, array('class' => 'form-control percent','id' => 'percent'.$item->id,'data-id' => $item->id, 'onChange' => 'cambiopercent(this.value,'.$item->id.')')) !!}
                                                                    </td>
                                                                    <td>
                                                                        {!! Form::number('total', $total, array('class' => 'form-control','id' => 'total'.$item->id)) !!}
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-danger quitar" data-id="{{$item->id}}" onclick="eliminar(ide= {{$item->id}})" type="button">Quitar</button>
                                                                    </td>
                                                                </tr>
                                                            @else
                                                                @php
                                                                    $total = ($item->costprice->price * $item->quantity) - $item->discount;
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
                                                                        {!! Form::number('quantity', $item->quantity, array('max' => $item->costprice->vendorproduct->stock,'min' => '1','class' => 'form-control quantity','id' => 'quantity'.$item->id,'data-id' => $item->id, 'onChange' => 'cambiocantidad(this.value,'.$item->id.')')) !!}
                                                                    </td>
                                                                    <td>
                                                                        {!! Form::number('percent', $item->percent, array('class' => 'form-control percent','id' => 'percent'.$item->id,'data-id' => $item->id, 'onChange' => 'cambiopercent(this.value,'.$item->id.')')) !!}
                                                                    </td>
                                                                    <td>
                                                                        {!! Form::number('total', $total, array('class' => 'form-control','id' => 'total'.$item->id)) !!}
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-danger quitar" onclick="eliminar(ide= {{$item->id}})"  data-id="{{$item->id}}" type="button">Quitar</button>
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
                                                <select name="" id="tipo-venta" class="form-control" onchange="tipoventa()">
                                                    <option value="Venta">Venta</option>
                                                    <option value="Cotizacion">Cotizacion</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="">Cliente</label>
                                                {!! Form::select('client_id', $clientes, null, array('class' => 'form-control','id' => 'clientes')) !!}
                                            </div>
                                        </div>
                                        <div class="col-3" id="new-cliente">
                                            <div class="form-group">
                                                <label for="">Cliente</label>
                                                <input type="text" class="form-control" id="cliente" placeholder="Nuevo Cliente">
                                            </div>
                                        </div>
                                        <div class="col-3" id="div-modo-pay">
                                            <div class="form-group">
                                                <label for="">Modo Pago</label>
                                                <select name="" id="modo-pay" class="form-control">
                                                    <option value="Credito">Credito</option>
                                                    <option value="Una Exhibicion">Una Exhibicion</option>
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
                                                    {!! Form::number('subtotal', $gtotal, array('class' => 'form-control','step' => 'any','readonly' => 'true','id' => 'subtotal')) !!}
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
                                                    {!! Form::number('total', $gtotal, array('class' => 'form-control','step' => 'any','readonly' => 'true','id' => 'total')) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3" id="div-abono">
                                            <div class="form-group">
                                                <label for="">Abono</label>
                                                {!! Form::number('abono', null, array('class' => 'form-control','step' => 'any','id' => 'abono')) !!}
                                            </div>
                                        </div>
                                        <div class="col-3" id="div-pago">
                                            <div class="form-group">
                                                <label for="">Pago con:</label>
                                                {!! Form::number('pay', null, array('class' => 'form-control','step' => 'any','id' => 'pagocon')) !!}
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
    </section>
    <script> 
        $(document).ready(function () {
            var divpro = false;
            var divser = false;
            var cot = true;
            var pay = false;
            $('#new-cliente').attr('hidden',true);
            $('#pay').on('click',function(){
                const data = {
                    total: $('#total').val(),
                    discount: $('#descuentoprecio').val(),
                    percent: $('#discount').val(),
                    method: $('#metodo-pay').children('option:selected').val(),
                    client_id: $('#clientes').children('option:selected').val(),
                    user_cash_id: $('#usercajas').val(),
                    abono: $('#abono').val(),
                    modo: $('#modo-pay').children('option:selected').val()
                };
                console.log(data);
                $.post("/ventas",data,function(response){
                    const status = response['status'];
                    const id = response['id'];
                    if (status == 200) {
                        window.open('ventas/'+id+'/ticket','_blank');
                        location.reload();
                    } else {
                        alert(response);
                    }
                });
            });
            $('#coti').on('click',function(){
                const data = {
                    total: $('#total').val(),
                    discount: $('#descuentoprecio').val(),
                    percent: $('#discount').val(),
                    method: "Efectivo",
                    client_id: $('#clientes').children('option:selected').val(),
                    user_cash_id: $('#usercajas').val(),
                    cliente: $('#cliente').val(),
                };
                console.log(data);
                $.post("/cotizaciones",data,function(response){
                    const status = response['status'];
                    if (status == 200) {
                        location.reload();
                    } else {
                        alert('Error al realizar la cotizacion');
                        console.log(response);
                    }
                });
            });

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

            $('.costos').on('change',function(){
                loading();
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
                        $('#divtotales').load(" #divtotales"); 
                        
                    } 
                    setTimeout(function(){
                        Swal.close();
                    },3000);
                   
                });
               
            });

            $('.add').on('click',function(){
                loading();
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
                        $('#divtotales').load(" #divtotales");
                       
                    }
                    setTimeout(function(){
                        Swal.close();
                    },3000);
                });
            });

            $('.quantity').on('change',function(){
                loading();
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
                        Swal.close();
                    }
                    else {
                        $("#refresh").load(" #refresh");
                        $('#divtotales').load(" #divtotales");
                    }
                });
            });

            $('.percent').on('change',function(){
                loading();
                const valor = $(this).val();
                const id = $(this).data('id');
                const precio = $('#precio'+id).val();
                const cantidad = $('#quantity'+id).val();
                const subtotal = cantidad * precio;
                const total = subtotal - ((subtotal * valor)/100);
                $('#total'+id).val(total);
                $('#subtotal').val(total);
                $('#total').val(total);
                Swal.close();
            });

        });

        

        function cambiocantidad(valores,ide) {
            loading();
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
                    Swal.close();
                }
                else {
                    Swal.close();
                    $("#refresh").load(" #refresh");
                    $('#divtotales').load(" #divtotales");

                }
            });
        }

        function cambiopercent(valores,ide) {
            loading();
            const valor = valores;
            const id = ide;
            const precio = $('#precio'+id).val();
            const cantidad = $('#quantity'+id).val();
            const subtotal = cantidad * precio;
            const descuento = (subtotal * valor)/100;
            const total = subtotal - descuento;

            const data = {
                percent: valor,
                discount: descuento,
            };
            $.ajax({
                type: "PUT",
                url: "/vender/"+id,
                data: data,
            }).then(function(data){
                const status = data['status'];
                if (status != 200) {
                    Swal.close();
                }
                else {
                    Swal.close();
                    $("#refresh").load(" #refresh");
                    $('#divtotales').load(" #divtotales");
                }
            });
        }

       

       
        function tipoventa()
        {
            console.log("cambio");
            var tipo = $(this).children("option:selected").val();
            if (tipo == "Cotizacion") {
                cot = false;
                pay = true;
                $('#div-modo-pay').attr('hidden',true);
                $('#div-metodo-pay').attr('hidden',true);
                $('#div-abono').attr('hidden',true);
                $('#div-pago').attr('hidden',true);
                $('#div-cambio').attr('hidden',true);
                $('#clientes').prepend("<option value='nuevo'>Nuevo Cliente</option>");

            } else {
                cot = true;
                pay = false;
                $('#div-modo-pay').attr('hidden',false);
                $('#div-metodo-pay').attr('hidden',false);
                $('#div-abono').attr('hidden',false);
                $('#div-pago').attr('hidden',false);
                $('#div-cambio').attr('hidden',false);
                $("#clientes option[value='nuevo']").remove();
                $('#new-cliente').attr('hidden',true);
            }
            $('#divcot').attr('hidden',cot);
            $('#divpay').attr('hidden',pay);
        }

        $('#tipo-venta').on('change',function(){
            var tipo = $(this).children("option:selected").val();
            if (tipo == "Cotizacion") {
                cot = false;
                pay = true;
                $('#div-modo-pay').attr('hidden',true);
                $('#div-metodo-pay').attr('hidden',true);
                $('#div-abono').attr('hidden',true);
                $('#div-pago').attr('hidden',true);
                $('#div-cambio').attr('hidden',true);
                $('#clientes').prepend("<option value='nuevo'>Nuevo Cliente</option>");

            } else {
                cot = true;
                pay = false;
                $('#div-modo-pay').attr('hidden',false);
                $('#div-metodo-pay').attr('hidden',false);
                $('#div-abono').attr('hidden',false);
                $('#div-pago').attr('hidden',false);
                $('#div-cambio').attr('hidden',false);
                $("#clientes option[value='nuevo']").remove();
                $('#new-cliente').attr('hidden',true);
            }
            $('#divcot').attr('hidden',cot);
            $('#divpay').attr('hidden',pay);
        });

        $('#discount').on('change',function(){
            const valor = $(this).val();
            const subtotal = $('#subtotal').val();
            const sub = (subtotal * valor)/100;
            const tot = subtotal - sub;
            $('#total').val(tot.toFixed(2));
            $('#descuentoprecio').val(sub.toFixed(2));
        });

        $('#modo-pay').on('change',function(){
            const modo = $(this).children('option:selected').val();
            if (modo == "Credito") {
                $('#clientes').prop('required',true);
                $('#div-abono').attr('hidden',false);
            } else {
                $('#clientes').prop('required',false);
                $('#div-abono').attr('hidden',true);
            }
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



        $('#clientes').on('change',function(){
            const seleccion = $(this).children('option:selected').val();
            if (seleccion == 'nuevo') {
                $('#new-cliente').attr('hidden',false);
            } else {
                $('#new-cliente').attr('hidden',true);
            }
        });

        $('#search').keyup(function(){
            var busqueda = $(this).val();
            $.get('/searchp/'+busqueda,function(response){
                console.log(response['data']);
            });
        });
        // $('.quitar').on('click',function(){
            
        //     const id = $(this).data('id');
        //     eliminar(id);
           
        // });
        function eliminar(ide)
        {
            loading();
            const id = ide;
            $.ajax({
                type: "DELETE",
                url: "/vender/"+id,
            }).then(function(data){
                const status = data['status'];
                if (status != 200) {
                    Swal.close();
                } else {
                    
                    $("#refresh").load(" #refresh");
                    $('#divtotales').load(" #divtotales");
                   
                }
              setTimeout(() => {
                Swal.close();
              }, 3000);  
            });
           
        }

    </script>
@endsection

