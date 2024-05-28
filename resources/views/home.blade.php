@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Dashboard</h3>
        </div>
        <!-- <div class="section-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="text-center">Dashboar</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        <div class="row  d-block">
            <div class="float-sm-right">
                {!! Form::open(['route' => 'history.store', 'method' => 'POST']) !!}
                <div class="input-group">
                    <div class="form-outline">
                        {!! Form::text('num_socio', null, [
                            'class' => 'form-control',
                            'placeholder' => 'Num Socio',
                            'autofocus' => 'true',
                        ]) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="section-body" style="margin-top: 100px">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="color: #fff;">Fecha</th>
                                    <th style="color: #fff;">Num Socio</th>
                                    <th style="color: #fff;">Nombre</th>
                                    <th style="color: #fff;">Apellidos</th>
                                </thead>
                                <tbody id="tableSucursales">
                                    @forelse ($registers as $register)
                                        <tr>
                                            <td>{{ $register->date }}</td>
                                            <td>{{ $register->num_socio }}</td>
                                            <td>{{ $register->name }}</td>
                                            <td>{{ $register->lastname }} {{ $register->second_lastname }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">Sin registros</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="pagination" id="pag">
                                {{ $registers->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
