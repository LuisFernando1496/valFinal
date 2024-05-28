@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Inventario del almacen "{{ $almacen->title }}"</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('crear-inventario')
                                <a href="{{ route('inventario.create',$almacen->id) }}" class="btn btn-warning">Nuevo</a>
                            @endcan
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="display: none;">ID</th>
                                    <th style="color: #fff;">Codigo</th>
                                    <th style="color: #fff;">Producto</th>
                                    <th style="color: #fff;">Costo</th>
                                    <th style="color: #fff;">Precio</th>
                                    <th style="color: #fff;">Stock</th>
                                    <th style="color: #fff;">Marca</th>
                                    <th style="color: #fff;">Categoria</th>
                                    <th style="color: #fff;">Editar</th>
                                    <th style="color: #fff;">Eliminar</th>
                                </thead>
                                <tbody>
                                    @forelse ($inventarios as $inventario)
                                        <tr>
                                            <td style="display: none;">{{ $inventario->id }}</td>
                                            <td>{{ $inventario->bar_code }}</td>
                                            <td>{{ $inventario->name }}</td>
                                            <td>${{ number_format($inventario->cost,2,'.',',') }}</td>
                                            <td>${{ number_format($inventario->price,2,'.',',') }}</td>
                                            <td>{{ $inventario->stock }}</td>
                                            <td>{{ $inventario->mark }}</td>
                                            <td>{{ $inventario->category->name }}</td>
                                            <td>
                                                @can('editar-inventario')
                                                    <a href="{{ route('inventario.edit',$inventario->id) }}" class="btn btn-info">Editar</a>
                                                @endcan
                                            </td>
                                            <td>
                                                @can('borrar-inventario')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['inventario.destroy',$inventario->id], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10">Sin registros</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pagination" id="pag">
                                {!! $inventarios->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

