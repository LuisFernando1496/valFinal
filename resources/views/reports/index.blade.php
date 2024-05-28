@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Reportes</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('reportes.store') }}" method="POST" id="formulario">
                                @csrf
                                <div class="form-group">
                                    <label for="">Tipo de reporte</label>
                                    <select name="type" id="type" class="form-control" required>
                                        <option value="General">General</option>
                                        <option value="Sucursales">Sucursales</option>
                                        <option value="Almacen">Almacen</option>
                                        <option value="Inventario">Inventario</option>
                                        <option value="Clientes">Clientes</option>
                                        <option value="Personal">Personal</option>
                                        <option value="Servicios">Servicios</option>
                                        <option value="Ventas">Ventas</option>
                                        <option value="Compras">Compras</option>
                                    </select>
                                </div>
                                <div class="form-group" id="divsucursales">
                                    <label for="">Sucursales</label>
                                    <select name="office_id" id="offices" class="form-control">
                                        @forelse ($sucursales as $sucursal)
                                            <option value="{{ $sucursal->id }}">{{ $sucursal->name }} - {{ $sucursal->business->name }}</option>
                                        @empty

                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group" id="divpersonal">
                                    <label for="">Personal</label>
                                    <select name="user_id" id="users" class="form-control">
                                        @forelse ($usuarios as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }} {{ $user->last_name }} {{ $user->second_last_name }}</option>
                                        @empty

                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group" id="divalmacenes">
                                    <label for="">Almacenes</label>
                                    <select name="warehouse_id" id="warehouses" class="form-control">
                                        @forelse ($almacenes as $almacen)
                                            <option value="{{ $almacen->id }}">{{ $almacen->title }}</option>
                                        @empty

                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group" id="divclientes">
                                    <label for="">Clientes</label>
                                    <select name="client_id" id="clientes" class="form-control">
                                        @forelse ($clientes as $cliente)
                                            <option value="{{ $cliente->id }}">{{ $cliente->name }} {{ $cliente->last_name }} {{ $cliente->second_last_name }}</option>
                                        @empty

                                        @endforelse
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Fecha Inicial</label>
                                            <input type="date" name="dateI" id="dateI" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="">Fecha Final</label>
                                            <input type="date" name="dateF" id="dateF" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <input type="text" class="form-control" hidden id="tipo" name="metodo">
                                <button class="btn btn-dark" type="button" id="imprimir" data-tipo="imprimir"><i class="fas fa-print"></i></button>
                                <button class="btn btn-danger" type="button" id="pdf" data-tipo="pdf"><i class="fas fa-file-pdf"></i></button>
                                <button class="btn btn-success" type="button" id="excel" data-tipo="excel"><i class="fas fa-file-excel"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $('#divsucursales').attr('hidden',true);
        $('#divpersonal').attr('hidden',true);
        $('#divalmacenes').attr('hidden',true);
        $('#divclientes').attr('hidden',true);
        $('#imprimir').on('click',function(){
            const tipo = $(this).data('tipo');
            $('#tipo').val(tipo);
            $('#formulario').submit();
        });
    </script>
@endsection

