@extends('layouts.app')

@section('content')
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
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

        .modal {
            z-index: 1024;
        }
    </style>
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Visitas</h3>
        </div>
        <div class="row  d-block">
            <div class="float-right">
                <div class="input-group">
                    <button onclick="$('#QRLector').modal('show');" type="button" class="btn btn-info ml-2 mr-2">
                        <i class="fas fa-qrcode"></i>
                    </button>
                    <div class="form-outline">
                        <input type="search" id="searchUser" onkeyup="searchUser()" class="form-control"
                            placeholder="Buscar" />
                        <input type="hidden" value="Visitas" id="option" name="option">
                    </div>
                    <button onclick="registUser();" type="button" class="btn btn-success ml-2 mr-2">
                        <i class="fas fa-plus"></i> Entrada
                    </button>
                </div>
            </div>
        </div>
        <div class="section-body" style="margin-top: 100px">
            @if (session('message'))
                <span class="badge badge-danger">{{ session('message') }}</span>
            @elseif(session('messageT'))
                <span class="badge badge-success badge-pill">{{ session('messageT') }}</span>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if (\Illuminate\Support\Facades\Auth::user()->id == 1)
                                <a href="{{ route('visitas.listado') }}" class="btn btn-warning">
                                    <span>Ver entradas de otras fechas</span>
                                </a>
                            @endif
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
                            {{-- <a href="{{ route('visitas.create') }}" class="btn btn-warning">Registrar visita</a> --}}
                            <div class="table-responsive">
                                <table class="table text-nowrap table-striped table-hover mt-2" id="visit">
                                    <thead style="background-color: #6777ef;">
                                        <th style="display: none;">ID</th>
                                        <th class="text-light">Numero de cliente</th>
                                        <th class="text-light">Nombre completo</th>
                                        <th class="text-center text-light">Entrada</th>
                                        <th class="text-center text-light">Salida</th>
                                    </thead>
                                    <tbody id="tableSucursales">
                                        @forelse ($visits as $data)
                                            <tr>
                                                <td style="display: none;">{{ $data->id }}</td>
                                                <td>{{ $data->partners->num_socio }}</td>
                                                <td>{{ $data->partners->name }} {{ $data->partners->last_name }}
                                                    {{ $data->partners->second_lastname }}</td>
                                                <td class="text-center">{{ explode(' ', $data->entrada)[1] }}</td>
                                                @if ($data->salida != '')
                                                    <td class="text-center">{{ explode(' ', $data->salida)[1] }}</td>
                                                @else
                                                    <td class="text-center">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['visitas.destroy', $data->id], 'style' => 'display:inline']) !!}
                                                        {!! Form::button('Registrar salida', [
                                                            'type' => 'submit',
                                                            'class' => 'badge badge-danger badge-pill',
                                                            'style' => 'border: 1px solid transparent;',
                                                        ]) !!}
                                                        {!! Form::close() !!}
                                                    </td>
                                                @endif
                                            </tr>
                                        @empty
                                        @endforelse
                                        <tr class='noSearch hide'>
                                            <td colspan="4">Se ha encontrado {{ count($visits) }}
                                                coincidencia{{ count($visits) > 1 ? 's' : '' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="pagination" id="pag">
                                {{ $visits->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="QRLector" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Registrar Entrada</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="cred">
                    <video id="qrvisor" class="w-100"></video>
                    {{-- <div class="row w-100">
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div id='viewModaldiv'></div>
    <script>
        function registUser(user = $("#searchUser").val()) {
            $("#viewModaldiv").html('');
            $.get('/visitas/socios/' + user, function(data) {
                $("#viewModaldiv").html(data);
                setTimeout(() => {
                    $('#QRModal').modal('show');
                }, 100);
            });
        }

        function searchUser() {
            const tableReg = document.getElementById('visit');
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
                if (found) tableReg.rows[i].style.display = '';
                else tableReg.rows[i].style.display = 'none';
            }
            // mostramos las coincidencias
            const lastTR = tableReg.rows[tableReg.rows.length - 1];
            const td = lastTR.querySelector("td");
            lastTR.classList.remove("hide", "red");
            if (searchText == "") lastTR.classList.add("hide");
            else if (total) td.innerHTML = "Se ha encontrado " + total + " coincidencia" + ((total > 1) ? "s" : "");
            else {
                lastTR.classList.add("red");
                td.innerHTML = "No se han encontrado coincidencias";
            }

        }
        var scanner = new Instascan.Scanner({
            video: document.getElementById('qrvisor'),
            scanPeriod: 10,
            mirror: false
        });

        Instascan.Camera.getCameras().then(function(cameras) {
            /* alert(cameras) */
            if (cameras.length > 0) {
                scanner.start(cameras[1]);
            } else {
                alert('No se encontró camara.')
            }
        }).catch(function(e) {
            alert(e)
            console.log(e)
        })

        scanner.addListener('scan', function(respuesta) {
            registUser(respuesta);

            //$('#searchUser').val(response)
        })
    </script>
@endsection
