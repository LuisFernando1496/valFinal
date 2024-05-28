@php
    $hoy = date('Y-n-d');
@endphp
@extends('layouts.app')

@section('content')
    <style>

    </style>
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Visitas</h3>
        </div>
        <div class="row d-block">
            <div class="input-group">
                <div class="form-group ml-1">
                    <label for="date1">Fecha Inicio</label>
                    <input class="form-control" id="date1" max='{{ $hoy }}' type="date" />
                </div>
                <div class="form-group ml-1">
                    <label for="date2">Fecha Final:</label>
                    <input class="form-control" id="date2" max='{{ $hoy }}' type="date" disabled />
                </div>
                {{-- <div class="form-group">
                    <label for="business_id">Pertenece</label>
                    {!! Form::select('business_id', $negocios, [], ['class' => 'form-control', 'id'=>'business_id']) !!}
                </div> --}}
                <div class="form-group ml-3 mt-2">
                    <button class="btn btn-warning mt-4" type="button" onclick="searchList()">Buscar</button>
                </div>
            </div>
        </div>
        <div class="row d-none" id="searchTab">
            <div class="float-right">
                <div class="input-group">
                    <div class="form-outline">
                        <input type="search" id="searchUser" onkeyup="searchUser()" class="form-control"
                            placeholder="Buscar" />
                        <input type="hidden" value="Visitas" id="option" name="option">
                    </div>
                </div>
            </div>
        </div>
        <div class="" id='tblList'></div>

    </section>
    <script>
        $(document).ready(function() {
            $('#date1').change(function() {
                $(this).val() == "" ? $('#date2').prop('disabled', true) :
                    $('#date2').prop('disabled', false);
            });
        });

        function searchList() {
            /* const date = fech => {
                const value = $("#date" + fech).val(),
                    data = value.split('-');
                return value != "" ? `${data[2]}-${data[1]}-${data[0]}` : '';
            } */

            $.ajax({
                type: "POST",
                url: "/visitas/data",
                async: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                data: {
                    /* date1: date(1),
                    date2: date(2), */
                    date1: $("#date1").val(),
                    date2: $("#date2").val(),
                },
                success: function(data) {
                    $("#searchTab").removeClass('d-none');
                    $("#searchTab").addClass('d-block');
                    $("#tblList").html(data);
                },
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
    </script>
@endsection
