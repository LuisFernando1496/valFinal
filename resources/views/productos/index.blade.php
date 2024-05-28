@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Productos</h3>
        </div>
        <div class="row  d-block">
            <div class="float-sm-right">
                <div class="input-group">
                    <div class="form-outline">
                        <input type="search" id="search" class="form-control" placeholder="Buscar"/>
                        <input type="hidden" value="Productos" id="option" name="option">
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
                            @can('crear-productos')
                                <a href="{{ route('productos.create') }}" class="btn btn-warning">Nuevo</a>
                            @endcan
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="display: none;">ID</th>
                                    <th style="color: #fff;">Codigo Barras</th>
                                    <th style="color: #fff;">Nombre</th>
                                    <th style="color: #fff;">Marca</th>
                                    <th style="color: #fff;">Categoria</th>
                                    <th style="color: #fff;">Costos</th>
                                    <th style="color: #fff">Stock</th>
                                    <th style="color: #fff;">Proveedor</th>
                                    <th style="color: #fff;">Sucursal</th>
                                    <th style="color: #fff;">Editar</th>
                                    <th style="color: #fff;">Eliminar</th>
                                </thead>
                                <tbody id="tableProductos">
                                    @forelse ($productos as $producto)
                                        <tr>
                                            <td style="display: none">{{ $producto->id }}</td>
                                            <td>{{ $producto->bar_code }}</td>
                                            <td>{{ $producto->name }}</td>
                                            <td>{{ $producto->mark }}</td>
                                            <td>{{ $producto->category->name }}</td>
                                            <td>
                                                @if (sizeof($producto->vendor[0]->costos) > 0)
                                                    <a href="{{ route('costos.ver',$producto->id) }}" class="btn btn-secondary">Ver</a>
                                                @else
                                                    <p>Sin costoso</p>
                                                @endif
                                                <a href="{{ route('costos.crear',$producto->vendor[0]->id) }}" class="btn btn-warning">Agregar</a>
                                            </td>
                                            <td>{{ $producto->vendor[0]->stock }}</td>
                                            <td>{{ $producto->vendor[0]->vendor->name }}</td>
                                            <td>{{ $producto->vendor[0]->vendor->office->name }}</td>
                                            <td>
                                                @can('editar-productos')
                                                    <a href="{{ route('productos.edit',$producto->id) }}" class="btn btn-info">Editar</a>
                                                @endcan
                                            </td>
                                            <td>
                                                @can('borrar-productos')
                                                    <a href="{{ route('productos.destroy',$producto->id) }}" class="btn btn-danger">Borrar</a>
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
                                {!! $productos->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

