@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Almacenes</h3>
        </div>

        <div class="row  d-block">
            <div class="float-sm-right">
                <div class="input-group">
                    <div class="form-outline">
                        <input type="search" id="search" class="form-control" placeholder="Buscar"/>
                        <input type="hidden" value="Almacenes" id="option" name="option">
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
                            @can('crear-almacenes')
                                <a href="{{ route('almacenes.create') }}" class="btn btn-warning">Nuevo</a>
                            @endcan
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="display: none;">ID</th>
                                    <th style="color: #fff;">Almacen</th>
                                    <th style="color: #fff;">Negocio</th>
                                    <th style="color: #fff;">Encargado</th>
                                    <th style="color: #fff;">Inventario</th>
                                    <th style="color: #fff;">Editar</th>
                                    <th style="color: #fff;">Eliminar</th>
                                </thead>
                                <tbody id ="tableAlmacenes">
                                    @forelse ($almacenes as $almacen)
                                        <tr>
                                            <td style="display: none;">{{ $almacen->id }}</td>
                                            <td>{{ $almacen->title }}</td>
                                            <td>{{ $almacen->business->name }}</td>
                                            <td>{{ $almacen->user->name }} {{ $almacen->user->last_name }} {{ $almacen->user->second_last_name }}</td>
                                            <td>
                                                <a href="{{ route('inventario.show',$almacen->id) }}" class="btn btn-primary">Inventario</a>
                                            </td>
                                            <td>
                                                @can('editar-almacenes')
                                                    <a href="{{ route('almacenes.edit',$almacen->id) }}" class="btn btn-info">Editar</a>
                                                @endcan
                                            </td>
                                            <td>
                                                @can('borrar-almacenes')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['almacenes.destroy',$almacen->id], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">Sin registros</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                           
                            <div class="pagination" id="pag">
                                {!! $almacenes->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

