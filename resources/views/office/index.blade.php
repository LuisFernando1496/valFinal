@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Sucursales</h3>
        </div>
        <div class="row  d-block">
            <div class="float-sm-right">
                <div class="input-group">
                    <div class="form-outline">
                        <input type="search" id="search" class="form-control" placeholder="Buscar"/>
                        <input type="hidden" value="Sucursales" id="option" name="option">
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
                            <a href="{{ route('sucursales.create') }}" class="btn btn-warning">Nuevo</a>
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="display: none;">ID</th>
                                    <th style="color: #fff;">Nombre</th>
                                    <th style="color: #fff;">Telefono</th>
                                    <th style="color: #fff;">Responsable</th>
                                    <th style="color: #fff;">Direccion</th>
                                    <th style="color: #fff;">Negocio</th>
                                    <th style="color: #fff;">Editar</th>
                                    <th style="color: #fff;">Eliminar</th>
                                </thead>
                                <tbody id="tableSucursales">
                                    @forelse ($oficinas as $sucursale)
                                        <tr>
                                            <td style="display: none;">{{ $sucursale->id}}</td>
                                            <td>{{ $sucursale->name }}</td>
                                            <td>{{ $sucursale->phone }}</td>
                                            <td>{{ $sucursale->responsable }}</td>
                                            <td>{{ $sucursale->address->street }} {{ $sucursale->address->number }} {{ $sucursale->address->suburb }}, {{ $sucursale->address->postal_code }}, {{ $sucursale->address->city }}, {{ $sucursale->address->state }}, {{ $sucursale->address->country }}</td>
                                            <td>{{ $sucursale->business->name }}</td>
                                            <td>
                                                <a href="{{ route('sucursales.edit',$sucursale) }}" class="btn btn-info">Editar</a>
                                            </td>
                                            <td>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['sucursales.destroy',$sucursale], 'style' => 'display:inline']) !!}
                                                    {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">Sin registros</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pagination" id="pag">
                                {!! $oficinas->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
