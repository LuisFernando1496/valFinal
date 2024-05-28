@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Clientes</h3>
        </div>
        <div class="row  d-block">
            <div class="float-sm-right">
                <div class="input-group">
                    <div class="form-outline">
                        <input type="search" id="search" class="form-control" placeholder="Buscar"/>
                        <input type="hidden" value="Clientes" id="option" name="option">
                    </div>
                    <button type="button" class="btn btn-primary ">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="section-body" style="margin-top: 100px">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('crear-clientes')
                                <a href="{{ route('clientes.create') }}" class="btn btn-warning">Nuevo</a>
                            @endcan
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="display: none;">ID</th>
                                    <th style="color: #fff;">Nombre(s)</th>
                                    <th style="color: #fff;">Apellido Paterno</th>
                                    <th style="color: #fff;">Apellido Materno</th>
                                    <th style="color: #fff;">Correo</th>
                                    <th style="color: #fff;">Sucursal</th>
                                    <th style="color: #fff;">Editar</th>
                                    <th style="color: #fff;">Eliminar</th>
                                </thead>
                                <tbody id="tableClientes">
                                    @forelse ($clientes as $cliente)
                                        <tr>
                                            <td style="display: none;">{{ $cliente->id }}</td>
                                            <td>{{ $cliente->name }}</td>
                                            <td>{{ $cliente->last_name }}</td>
                                            <td>{{ $cliente->second_last_name }}</td>
                                            <td>{{ $cliente->email }}</td>
                                            <td>{{ $cliente->office->name }}</td>
                                            <td>
                                                @can('editar-clientes')
                                                    <a href="{{ route('clientes.edit',$cliente->id) }}" class="btn btn-info">Editar</a>
                                                @endcan
                                            </td>
                                            <td>
                                                @can('borrar-clientes')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['clientes.destroy',$cliente->id], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11">Sin registros</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pagination" id="pag">
                                {!! $clientes->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

