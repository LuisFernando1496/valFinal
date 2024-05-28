@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Usuarios</h3>
        </div>
        <div class="row  d-block">
            <div class="float-sm-right">
                <div class="input-group">
                    <div class="form-outline">
                        <input type="search" id="search" class="form-control" placeholder="Buscar"/>
                        <input type="hidden" value="Usuarios" id="option" name="option">
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
                            <a href="{{ route('usuarios.create') }}" class="btn btn-warning">Nuevo</a>
                            <a href="{{ route('roles.index') }}" class="btn btn-primary">Roles</a>
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="display: none;">ID</th>
                                    <th style="color: #fff;">Nombre(s)</th>
                                    <th style="color: #fff;">Apellido Paterno</th>
                                    <th style="color: #fff;">Apellido Materno</th>
                                    <th style="color: #fff;">Correo</th>
                                    <th style="color: #fff;">Sucursal</th>
                                    <th style="color: #fff;">Rol</th>
                                    <th style="color: #fff;">Editar</th>
                                    <th style="color: #fff;">Eliminar</th>
                                </thead>
                                <tbody id="tableUsuarios">
                                    @forelse ($users as $user)
                                        <tr>
                                            <td style="display: none;">{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->last_name }}</td>
                                            <td>{{ $user->second_last_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->office->name ?? '' }}</td>
                                            <td>
                                                @if (!empty($user->getRoleNames()))
                                                    @foreach ($user->getRoleNames() as $rolName)
                                                        <h5><span class="badge badge-dark">{{ $rolName }}</span></h5>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('usuarios.edit',$user->id) }}" class="btn btn-info">Editar</a>
                                            </td>
                                            <td>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['usuarios.destroy',$user->id], 'style' => 'display:inline']) !!}
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
                                {!! $users->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

