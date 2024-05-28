@extends('layouts.app')

@section('content')
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            /* padding-top: 50px; */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 1024;
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        /* The Close Button */
        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-primary:not(:disabled):not(.disabled).active,
        .btn-primary:not(:disabled):not(.disabled):active,
        .show>.btn-primary.dropdown-toggle {
            color: #fff;
            background-color: #ed5a14 !important;
            border-color: #005cbf;
        }

        .table:not(.table-sm):not(.table-md):not(.dataTable) td,
        .table:not(.table-sm):not(.table-md):not(.dataTable) th {
            padding: 0 15px;
            height: 50px;
            vertical-align: middle;
        }
    </style>
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Socios</h3>
        </div>
        <div class="row  d-block">
            <div class="float-right">
                <div class="input-group">
                    <div class="form-outline">
                        <input type="search" id="searchUser" onkeyup="searchUser()" class="form-control mr-3"
                            placeholder="Buscar" style="width:300px;" />
                        <input type="hidden" value="Socios" id="option" name="option">
                    </div>
                </div>
            </div>
        </div>

        <div class="section-body" style="margin-top: 100px">
            <div class="card">
                <ul class="nav nav-pills nav-tabs m-4">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#menu1">
                            VALPARAISO
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#menu2">
                            AGUACALIENTE
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="menu1" class="tab-pane active">
                        <div class="card-body">
                            <style>
                                #tableSucursales .dropdown-item {
                                    font-size: 17px !important;
                                    cursor: pointer !important;
                                    padding: 10px 20px !important;
                                }

                                #tableSucursales .dropdown-item .fas {
                                    font-size: 17px !important;
                                    cursor: pointer !important;
                                }
                            </style>
                            <a href="{{ route('socios.create') }}" class="btn btn-warning">Nuevo</a>
                            <table class="table text-nowrap table-striped table-responsive table-hover mt-2" id="soc">
                                <thead style="background-color: #6777ef;">
                                    <th style="display: none;">ID</th>
                                    <th style="color: #fff; width:auto;">Numero de cliente</th>
                                    <th style="color: #fff; width:auto;">Nombre Completo</th>
                                    {{-- <th style="color: #fff; width:auto;">Apellidos</th> --}}
                                    <th style="color: #fff; width:auto;">Telefono</th>
                                    <th style="color: #fff; width:100%;" class="text-center">Archivos</th>
                                    <th style="color: #fff; width:auto;">Status</th>
                                    {{-- <th style="color: #fff; width:auto;">Motivos</th> --}}
                                    <th style="color: #fff; width:auto;">Acciones</th>
                                </thead>
                                <tbody id="tableSucursales">
                                    @forelse ($partnersVal as $partner)
                                        <tr>
                                            <td style="display: none;">{{ $partner->Partners->id }}</td>
                                            <td>{{ $partner->Partners->num_socio }}</td>
                                            <td>{{ $partner->Partners->name }}
                                                {{ $partner->Partners->last_name }}
                                                {{ $partner->Partners->second_lastname }}</td>
                                            {{-- <td>{{ $partner->last_name }} {{ $partner->second_lastname }}</td> --}}
                                            <td>{{ $partner->Partners->phone }}</td>
                                            <td class="text-center">
                                                @if ($partner->Partners->cer != null)
                                                    <span class="badge badge-success badge-pill">Cons.
                                                        Médica</span>
                                                @else
                                                    <span class="badge badge-danger badge-pill">Cons.
                                                        Médica</i></span>
                                                @endif
                                                @if ($partner->Partners->firma != null)
                                                    <span class="badge badge-success badge-pill">Firma
                                                        Digital</span>
                                                @else
                                                    <span class="badge badge-danger badge-pill">Firma
                                                        Digital</i></span>
                                                @endif
                                                @if ($partner->Partners->foto != null)
                                                    <span class="badge badge-success badge-pill">Foto
                                                        Socio</i></span>
                                                @else
                                                    <span class="badge badge-danger badge-pill">Foto
                                                        Socio</i></span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($partner->Partners->status == 1)
                                                    <span class="badge badge-success badge-pill">ACTIVO</span>
                                                @else
                                                    <span class="badge badge-danger badge-pill" style="cursor: pointer;"
                                                        onclick="getBaja('{{ $partner->Partners->comm }}')">BAJA</i></span>
                                                @endif
                                            </td>
                                            {{-- <td>{{ $partner->comm }}</td> --}}
                                            <td class="text-center">
                                                <div class="btn-group dropleft">
                                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item text-warning"
                                                            data-toggle="modal"data-target="#QRModal" id="dataToModal"
                                                            onclick="sendData({{ $partner->Partners->id }},1)">
                                                            <i class="fas fa-id-card"></i>&nbsp;Ver
                                                            Credencial</a>
                                                        <a class="dropdown-item text-info"
                                                            href="{{ route('socios.edit', $partner->Partners) }}"><i
                                                                class="fas fa-edit"></i>&nbsp;Modificar
                                                            Datos</a>
                                                        {{-- {!! Form::open(['method' => 'DELETE', 'rou/te' => ['socios.destroy', $partner], 'style' => 'display:inline']) !!} --}}
                                                        {!! Form::button('&nbsp;<i class="fa fa-user-times"></i>&nbsp;&nbsp;Dar baja a socio', [
                                                            /* 'type' => 'submit', */
                                                            'class' => 'dropdown-item text-danger',
                                                            'onclick' => 'baja(' . $partner->Partners->id . ')',
                                                        ]) !!}
                                                        {{-- {!! Form::submit('Eliminar Socio', ['class' => 'dropdown-item']) !!} --}}
                                                        {!! Form::close() !!}
                                                        {{-- @include ('socios.ficha_pago1') --}}
                                                        <a class="dropdown-item text-success" data-toggle="modal"
                                                            data-target="#fichaModal"
                                                            onclick="sendData({{ $partner->Partners->id }},2)"><i
                                                                class="fas fa-money-check-alt"></i>&nbsp;Gestor
                                                            de
                                                            Pagos</a>
                                                        {!! Form::open(['method' => 'POST', 'route' => ['senEmail', $partner->Partners], 'style' => 'display:inline']) !!}
                                                        {{-- {!! Form::submit('Enviar Reglamento', ['class' => 'dropdown-item']) !!} --}}
                                                        {!! Form::button('<i class="fa fa-scroll"></i>&nbsp;Enviar Reglamento', [
                                                            'type' => 'submit',
                                                            'class' => 'dropdown-item text-primary',
                                                        ]) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                    <tr class='noSearch hide text-primary'>
                                        <td colspan="6">Se han encontrado {{ count($partnersVal) }}
                                            socio{{ count($partnersVal) > 1 ? 's' : '' }}</td>
                                    </tr>
                                    {{-- @include('socios.modals', ['partnerData' => $partner]) --}}
                                </tbody>
                            </table>
                            <div class="pagination" id="pag">
                                {{ $partnersVal->links() }}
                            </div>
                        </div>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <div class="card-body">
                            <style>
                                #tableSucursales .dropdown-item {
                                    font-size: 17px !important;
                                    cursor: pointer !important;
                                    padding: 10px 20px !important;
                                }

                                #tableSucursales .dropdown-item .fas {
                                    font-size: 17px !important;
                                    cursor: pointer !important;
                                }
                            </style>
                            <a href="{{ route('socios.create') }}" class="btn btn-warning">Nuevo</a>
                            <table class="table text-nowrap table-striped table-responsive table-hover mt-2" id="soc">
                                <thead style="background-color: #6777ef;">
                                    <th style="display: none;">ID</th>
                                    <th style="color: #fff; width:auto;">Numero de cliente</th>
                                    <th style="color: #fff; width:auto;">Nombre Completo</th>
                                    {{-- <th style="color: #fff; width:auto;">Apellidos</th> --}}
                                    <th style="color: #fff; width:auto;">Telefono</th>
                                    <th style="color: #fff; width:100%;" class="text-center">Archivos</th>
                                    <th style="color: #fff; width:auto;">Status</th>
                                    {{-- <th style="color: #fff; width:auto;">Motivos</th> --}}
                                    <th style="color: #fff; width:auto;">Acciones</th>
                                </thead>
                                <tbody id="tableSucursales">
                                    @forelse ($partnersAgua as $partner)
                                        <tr>
                                            <td style="display: none;">{{ $partner->Partners->id }}</td>
                                            <td>{{ $partner->Partners->num_socio }}</td>
                                            <td>{{ $partner->Partners->name }}
                                                {{ $partner->Partners->last_name }}
                                                {{ $partner->Partners->second_lastname }}</td>
                                            {{-- <td>{{ $partner->last_name }} {{ $partner->second_lastname }}</td> --}}
                                            <td>{{ $partner->Partners->phone }}</td>
                                            <td class="text-center">
                                                @if ($partner->Partners->cer != null)
                                                    <span class="badge badge-success badge-pill">Cons.
                                                        Médica</span>
                                                @else
                                                    <span class="badge badge-danger badge-pill">Cons.
                                                        Médica</i></span>
                                                @endif
                                                @if ($partner->Partners->firma != null)
                                                    <span class="badge badge-success badge-pill">Firma
                                                        Digital</span>
                                                @else
                                                    <span class="badge badge-danger badge-pill">Firma
                                                        Digital</i></span>
                                                @endif
                                                @if ($partner->Partners->foto != null)
                                                    <span class="badge badge-success badge-pill">Foto
                                                        Socio</i></span>
                                                @else
                                                    <span class="badge badge-danger badge-pill">Foto
                                                        Socio</i></span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($partner->Partners->status == 1)
                                                    <span class="badge badge-success badge-pill">ACTIVO</span>
                                                @else
                                                    <span class="badge badge-danger badge-pill" style="cursor: pointer;"
                                                        onclick="getBaja('{{ $partner->Partners->comm }}')">BAJA</i></span>
                                                @endif
                                            </td>
                                            {{-- <td>{{ $partner->comm }}</td> --}}
                                            <td class="text-center">
                                                <div class="btn-group dropleft">
                                                    <button type="button" class="btn btn-primary dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item text-warning"
                                                            data-toggle="modal"data-target="#QRModal" id="dataToModal"
                                                            onclick="sendData({{ $partner->Partners->id }},1)">
                                                            <i class="fas fa-id-card"></i>&nbsp;Ver
                                                            Credencial</a>
                                                        <a class="dropdown-item text-info"
                                                            href="{{ route('socios.edit', $partner->Partners) }}"><i
                                                                class="fas fa-edit"></i>&nbsp;Modificar
                                                            Datos</a>
                                                        {{-- {!! Form::open(['method' => 'DELETE', 'rou/te' => ['socios.destroy', $partner], 'style' => 'display:inline']) !!} --}}
                                                        {!! Form::button('&nbsp;<i class="fa fa-user-times"></i>&nbsp;&nbsp;Dar baja a socio', [
                                                            /* 'type' => 'submit', */
                                                            'class' => 'dropdown-item text-danger',
                                                            'onclick' => 'baja(' . $partner->Partners->id . ')',
                                                        ]) !!}
                                                        {{-- {!! Form::submit('Eliminar Socio', ['class' => 'dropdown-item']) !!} --}}
                                                        {!! Form::close() !!}
                                                        {{-- @include ('socios.ficha_pago1') --}}
                                                        <a class="dropdown-item text-success" data-toggle="modal"
                                                            data-target="#fichaModal"
                                                            onclick="sendData({{ $partner->Partners->id }},2)"><i
                                                                class="fas fa-money-check-alt"></i>&nbsp;Gestor
                                                            de
                                                            Pagos</a>
                                                        {!! Form::open(['method' => 'POST', 'route' => ['senEmail', $partner->Partners], 'style' => 'display:inline']) !!}
                                                        {{-- {!! Form::submit('Enviar Reglamento', ['class' => 'dropdown-item']) !!} --}}
                                                        {!! Form::button('<i class="fa fa-scroll"></i>&nbsp;Enviar Reglamento', [
                                                            'type' => 'submit',
                                                            'class' => 'dropdown-item text-primary',
                                                        ]) !!}
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                    <tr class='noSearch hide text-primary'>
                                        <td colspan="6">Se han encontrado {{ count($partnersAgua) }}
                                            socio{{ count($partnersAgua) > 1 ? 's' : '' }}</td>
                                    </tr>
                                    {{-- @include('socios.modals', ['partnerData' => $partner]) --}}
                                </tbody>
                            </table>
                            <div class="pagination" id="pag">
                                {{ $partnersAgua->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id='modalData'></div>
    <script>
        function sendData(socio, tipo) {
            $("#modalData").html('');
            if (tipo == 1) {
                $.get('socios/modal/' + socio, function(data) {
                    $("#modalData").html(data);
                    setTimeout(() => {
                        $('#QRModal').modal('show');
                    }, 100);
                });
            } else {
                $.get('socios/fichaPago/' + socio, function(data) {
                    $("#modalData").html(data);
                    setTimeout(() => {
                        $('#fichaModal').modal('show');
                    }, 100);
                });

            }
        }

        function baja(val) {
            Swal.fire({
                title: 'MOTIVO DE BAJA',
                text: "Escriba el motivo de baja",
                input: 'text',
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: 'POST',
                        url: "/socios/" + val,
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        data: {
                            motivo: result.value,
                        },
                        success: function(data) {
                            window.location.reload();
                        }
                    }); //end ajax

                } //end if
            });
        }

        function getBaja(message) {
            Swal.fire({
                icon: 'warning',
                title: 'Motivo',
                text: message,
            })
        }

        function searchUser() {
            const tableReg = document.getElementById('soc');
            const searchText = document.getElementById('searchUser').value.toLowerCase();
            let total = 0;
            // Recorremos todas las filas con contenido de la tabla
            for (let i = 1; i < tableReg.rows.length; i++) {
                // Si el td tiene la clase "noSearch" no se busca en su cntenido
                if (tableReg.rows[i].classList.contains("noSearch")) continue;
                let found = false;
                const cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
                // Recorremos todas las celdas
                for (let j = 0; j < cellsOfRow.length && !found; j++) {
                    const compareWith = cellsOfRow[j].innerHTML.toLowerCase();
                    // Buscamos el texto en el contenido de la celda
                    if (searchText.length == 0 || compareWith.indexOf(searchText) > -1) {
                        found = true;
                        total++;
                    }
                }
                // si no ha encontrado ninguna coincidencia, esconde la
                // fila de la tabla
                found ? tableReg.rows[i].style.display = '' : tableReg.rows[i].style.display = 'none';
            }
            // mostramos las coincidencias
            const lastTR = tableReg.rows[tableReg.rows.length - 1];
            const td = lastTR.querySelector("td");
            lastTR.classList.remove("hide", "red");
            if (searchText == "") lastTR.classList.add("hide");
            else if (total) td.innerHTML = "Se han encontrado " + total + " socio" + ((total > 1) ? "s" : "");
            else {
                lastTR.classList.add("red");
                td.innerHTML = "No se encontró socio";
            }
        }
    </script>
@endsection
