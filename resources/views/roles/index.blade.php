@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Roles</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('crear-rol')
                                <a href="{{ route('roles.create') }}" class="btn btn-warning">Nuevo</a>
                            @endcan
                            <table class="table table-hover mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;">Rol</th>
                                    <th style="color: #fff;">Editar</th>
                                    <th style="color: #fff;">Eliminar</th>
                                </thead>
                                <tbody>
                                    @forelse ($roles as $role)
                                        <tr>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @can('editar-rol')
                                                    <a href="{{ route('roles.edit',$role->id) }}" class="btn btn-info">Editar</a>
                                                @endcan
                                            </td>
                                            <td>
                                                @can('borrar-rol')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy',$role->id], 'style' => 'display:inline']) !!}
                                                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">Sin roles</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pagination">
                                {!! $roles->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

