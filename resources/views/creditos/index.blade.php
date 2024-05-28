@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Creditos</h3>
        </div>
        <div class="row  d-block">
            <div class="float-sm-right">
                <div class="input-group">
                    <div class="form-outline">
                        <input type="search" id="search" class="form-control" placeholder="Buscar"/>
                        <input type="hidden" value="Creditos" id="option" name="option">
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
                            @can('crear-creditos')
                                <a href="{{route('creditos.create')}}" class="btn btn-success">Nuevo</a>
                            @endcan
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;">Cliente</th>
                                    <th style="color: #fff;">Cantidad de credito</th>
                                    <th style="color: #fff;">Credito disponible</th>
                                    <th style="color: #fff;">Fecha</th>
                                    <th colspan="3"> </th>
                                </thead>
                                <tbody id="tableCreditos">
                                    @forelse ($creditos as $credito)
                                    <tr>
                                        
                                        <td>{{$credito->client->fullname()}}</td>
                                        <td>${{$credito->amount}}</td>
                                        <td>${{$credito->available}}</td>
                                        <td>{{$credito->created_at}}</td>
                                        <td>
                                                @can('editar-creditos')
                                                    <a href="{{ route('historyShop',$credito->client) }}" class="btn btn-info">ver compras</a>
                                                   
                                                    @endcan
                                            </td>
                                            <td>
                                            @can('editar-creditos')
                                                    <a href="{{ route('creditos.edit',$credito) }}" class="btn btn-warning">Editar</a>
                                                    @endcan
                                            </td>
                                            <td>
                                            @can('borrar-creditos')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['creditos.destroy',$credito->id], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                @endcan
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
                              {{ $creditos->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

