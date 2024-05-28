@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Costos del Producto {{ $producto->name }}</h3>
        </div>
        
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('productos.index') }}" class="btn btn-success">Regresar</a>
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="display: none;">ID</th>
                                    <th style="color: #fff;">Nombre</th>
                                    <th style="color: #fff;">Costo</th>
                                    <th style="color: #fff;">Precio</th>
                                    <th style="color: #fff;">Editar</th>
                                    <th style="color: #fff;">Eliminar</th>
                                </thead>
                                <tbody>
                                    @forelse ($costos as $costo)
                                        <tr>
                                            <td style="display: none;">{{ $costo->id }}</td>
                                            <td>{{ $costo->name }}</td>
                                            <td>${{ number_format($costo->cost,2,'.',',') }}</td>
                                            <td>${{ number_format($costo->price,2,'.',',') }}</td>
                                            <td>
                                                <a href="{{ route('costos.edit',$costo->id) }}" class="btn btn-info">Editar</a>
                                            </td>
                                            <td>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['costos.destroy',$costo->id], 'style' => 'display:inline']) !!}
                                                    {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @empty

                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pagination" id="pag">
                                {!! $costos->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

