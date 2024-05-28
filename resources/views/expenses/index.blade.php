@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Gastos</h3>
        </div>
        <div class="row  d-block">
            <div class="float-sm-right">
                <div class="input-group">
                    <div class="form-outline">
                        <input type="search" id="search" class="form-control" placeholder="Buscar" />
                        <input type="hidden" value="Gastos" id="option" name="option">
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
                            @can('crear-gastos')
                                <a href="{{ route('expenses.create') }}" class="btn btn-success">Nuevo</a>
                            @endcan

                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;">Nombre del gasto</th>
                                    <th style="color: #fff;">Descripcion</th>
                                    <th style="color: #fff;">Tipo</th>
                                    <th style="color: #fff;">Total</th>
                                    <th style="color: #fff;">Generado por: </th>
                                    <th style="color: #fff;">Sucursal</th>
                                    <th style="color: #fff; text-align: center">Fecha</th>
                                    <th colspan="3" style="color: #fff; text-align: center">Acciones </th>
                                </thead>
                                <tbody id="tableGastos">
                                    @forelse ($expenses as $gasto)
                                        @php
                                            $title = $gasto->title;
                                        @endphp
                                        <tr>
                                            <td>{{ $gasto->title }}</td>
                                            <td>{{ $gasto->description }}</td>
                                            <td> <span class="badge badge-info float-center">
                                                    {{ $gasto->categoryOfExpense->name }}
                                                </span></td>
                                            <td>${{ number_format($gasto->total, 2) }}</td>
                                            <td>{{ $gasto->user->name }}</td>
                                            <td>{{ $gasto->office->name }}</td>
                                            <td>{{ $gasto->date }}</td>
                                            <td>
                                                @if ( $gasto->categoryOfExpense->id == 6 || $gasto->categoryOfExpense->id == 7)
                                                    @can('editar-gastos')
                                                       <a href="{{ route('expenses.vaucher', $gasto) }}"
                                                        class="btn btn-info">Vale</a>
                                                      @endcan
                                                @else
                                                    
                                                @endif
                                               
                                            </td>
                                            <td>

                                                @can('editar-gastos')
                                                    <a href="{{ route('expenses.edit', $gasto) }}"
                                                        class="btn btn-warning">Editar</a>
                                                @endcan
                                            </td>
                                            <td>
                                                @can('borrar-gastos')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['expenses.destroy', $gasto], 'style' => 'display:inline']) !!}
                                                    {!! Form::submit('Borrar', ['class' => 'btn btn-danger', 'onclick' => "return confirm('¿Seguro que desea elminar: $title?')"]) !!}
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
                                {{ $expenses->links() }}
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
