@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Cotizaciones</h3>
        </div>
        <div class="row  d-block">
            <div class="float-sm-right">
                <div class="input-group">
                    <div class="form-outline">
                        <input type="search" id="search" class="form-control" placeholder="Buscar"/>
                        <input type="hidden" value="Cotizaciones" id="option" name="option">
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
                            <table class="table table-hover mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="display: none;">ID</th>
                                    <th style="color: #fff;">Folio</th>
                                    <th style="color: #fff;">Cliente</th>
                                    <th style="color: #fff;">Total</th>
                                    <th style="color: #fff;">Fecha</th>
                                    <th style="color: #fff;">Atendio</th>
                                    <th style="color: #fff;">Detalles</th>
                                    <th style="color: #fff;">Vender</th>
                                    <th style="color: #fff;">Imprimir</th>
                                    <th style="color: #fff;">Cancelar</th>
                                </thead>
                                <tbody id="tableCotizaciones">
                                    @forelse ($cotizaciones as $cotizacion)
                                        <tr>
                                            <td style="display: none;">{{ $cotizacion->id }}</td>
                                            <td>{{ $cotizacion->folio }}</td>
                                            <td>
                                                @if ($cotizacion->cliente != null)
                                                    {{ $cotizacion->cliente }}
                                                @else
                                                    {{ $cotizacion->client->name }} {{ $cotizacion->client->last_name }} {{ $cotizacion->client->second_last_name }}
                                                @endif
                                            </td>
                                            <td>${{ $cotizacion->total }}</td>
                                            <td>{{ $cotizacion->date }}</td>
                                            <td>{{ $cotizacion->usercash->user->name }} {{ $cotizacion->usercash->user->last_name }}</td>
                                            <td>
                                                <a href="{{ route('cotizaciones.show',$cotizacion->id) }}" class="btn btn-info">Detalles</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('cotizaciones.edit',$cotizacion->id) }}" class="btn btn-success">Vender</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('cotizaciones.imprimir',$cotizacion->id) }}" class="btn btn-dark" target="blank">Imprimir</a>
                                            </td>
                                            <td>
                                                @can('borrar-cotizaciones')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['cotizaciones.destroy',$cotizacion->id], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Cancelar', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty

                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pagination" id="pag">
                                {!! $cotizaciones->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

