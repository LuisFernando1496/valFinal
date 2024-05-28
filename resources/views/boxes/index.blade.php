@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Cajas</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('crear-cajas')
                                <a href="{{ route('boxes.create') }}" class="btn btn-warning">Nuevo</a>
                            @endcan
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="display: none;">ID</th>
                                    <th style="color: #fff;">Caja</th>
                                    <th style="color: #fff;">Monto Inicial</th>
                                    <th style="color: #fff;">Sucursal</th>
                                    <th style="color: #fff;">Editar</th>
                                    <th style="color: #fff;">Eliminar</th>
                                </thead>
                                <tbody>
                                    @forelse ($cajas as $caja)
                                        <tr>
                                            <td style="display: none;">{{ $caja->id }}</td>
                                            <td>{{ $caja->number }}</td>
                                            <td>{{ $caja->starting_amount }}</td>
                                            <td>{{ $caja->office->name }}</td>
                                            <td>
                                                @can('editar-cajas')
                                                    <a href="{{ route('boxes.edit',$caja->id) }}" class="btn btn-info">Editar</a>
                                                @endcan
                                            </td>
                                            <td>
                                                @can('borrar-cajas')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['boxes.destroy',$caja->id], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty

                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pagination" id="pag">
                                {!! $cajas->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

