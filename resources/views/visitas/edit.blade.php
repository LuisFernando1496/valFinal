@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Edicion datos de socio {{ $partner->num_socio }}</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                    <strong>Revisa los campos!</strong>
                                    @foreach ($errors->all() as $error)
                                        <span class="badge badge-danger">{{ $error }}</span>
                                    @endforeach
                                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                            @endif

                            {!! Form::model($partner, [
                                'method' => 'PUT',
                                'route' => ['socios.update', $partner->id],
                                'enctype' => 'multipart/form-data',
                            ]) !!}
                            <div class="row">

                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nombre</label>
                                        {!! Form::text('name', $partner->name, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">Primer apellido</label>
                                        {!! Form::text('last_name', $partner->last_name, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group">
                                        <label for="second_lastname">Segundo apellido</label>
                                        {!! Form::text('second_lastname', $partner->second_lastname, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group">
                                        <label for="email">Correo</label>
                                        {!! Form::text('email', $partner->email, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group">
                                        <label for="age">Años</label>
                                        {!! Form::number('age', $partner->age, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Telefono</label>
                                        {!! Form::number('phone', $partner->phone, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group">
                                        <label for="phone_emergency">Telefono de emergencia</label>
                                        {!! Form::number('phone_emergency', $partner->phone_emergency, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xl-4 col-md-6">
                                    <div class="form-group">
                                        <label for="certificate">Constancia medica</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-warning" style="z-index: 0;" id="showFile"
                                                    type="button">Subir
                                                    Archivo</button>
                                            </div>
                                            <input type="text" id="nameFile" class="form-control"
                                                placeholder="Nombre de Archivo" readonly>
                                        </div>
                                        {!! Form::file('certificate', ['class' => 'd-none', 'id' => 'dataFile']) !!}
                                    </div>
                                </div>
                                {{-- <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="certificate">Subir nueva constancia medica</label>
                                        {!! Form::file('certificate', null, ['class' => 'form-control', 'require']) !!}
                                    </div>
                                </div> --}}

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <ul class="list-group">
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Constancia Medica
                                                @if ($partner->cer != null)
                                                    <span class="badge badge-success badge-pill"><i
                                                            class="bi bi-check"></i></span>
                                                @else
                                                    <span class="badge badge-danger badge-pill"><i
                                                            class="bi bi-x"></i></span>
                                                @endif
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Firma Digital
                                                @if ($partner->firma != null)
                                                    <span class="badge badge-success badge-pill"><i
                                                            class="bi bi-check"></i></span>
                                                @else
                                                    <span class="badge badge-danger badge-pill"><i
                                                            class="bi bi-x"></i></span>
                                                @endif
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                Foto Socio
                                                @if ($partner->foto != null)
                                                    <span class="badge badge-success badge-pill"><i
                                                            class="bi bi-check"></i></span>
                                                @else
                                                    <span class="badge badge-danger badge-pill"><i
                                                            class="bi bi-x"></i></span>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="">Proceso para nueva firma digital y foto</label>
                                        @include ('socios.webCam_Signature')
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <button class="btn btn-primary form-control" type="submit">Guardar</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        var showFile = document.getElementById("showFile");
        var nameFile = document.getElementById("nameFile");
        var dataFile = document.getElementById("dataFile");
        showFile.onclick = function() {
            dataFile.click();
            dataFile.onchange = function() {
                nameFile.value = dataFile.files[0].name;
            }
        }
    </script>
@endsection
