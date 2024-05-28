@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Dueños</h3>
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
                                    <th colspan="2" style="color: #fff;">Acciones</th>
                                </thead>
                                <tbody id="tableSucursales">
                                    @forelse ($owners as $owner)
                                        <tr>
                                            
                                            <td>{{ $owner->owner_name }}</td>
                                            <td>{{ $owner->owner_phone }}</td>
                                            <td>
                                                <a href="{{ route('sucursales.edit',$owner) }}" class="btn btn-info">Editar</a>
                                            </td>
                                            <td>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['sucursales.destroy',$owner], 'style' => 'display:inline']) !!}
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
                                    {{ $owners->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    @endsection