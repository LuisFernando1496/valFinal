<style>
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        padding-top: 100px;
        /* Location of the box */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
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
</style>

<div class="col-xs-12 col-sm-12 col-md-12">
    <input type="button" class="btn btn-primary form-control" id="myBtn" value="Pagos">
</div>

<div id="fichaModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <br>

        <h3>Ficha Tecnica</h3>
        <hr>
        <div id="accordion">
            <div class="card">
                <div class="card-header" id="patologico">
                    <h5>
                        <input type="button" class="btn-link" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="true" aria-controls="collapseOne" value="Antecedentes Patologicos">
                    </h5>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="patologico" data-parent="#accordion">
                    <div class="card-body">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="">
                                    Es alergico a algun medicamento
                                    <input type="button" value="?" class="btn btn-secondary btn-sm"
                                        data-container="body" data-toggle="popover" data-placement="top"
                                        data-content="En caso de ser No la respuesta, dejarlo en blanco.">
                                    :
                                </label>
                                {!! Form::text('answers[]', null, ['class' => 'form-control', 'id' => 'med_id', 'placeholder' => 'Cual']) !!}
                            </div>
                        </div>
                        <label for="">Padece usted alguno de los siguientes problemas:</label>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Presión Arterial:</label>
                                            <div class="form-check">
                                                {!! Form::checkbox('answers[]', 1, false) !!} <label for="">Si</label>
                                                {!! Form::checkbox('answers[]', 0, false) !!} <label for="">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Diabetes:</label>
                                            <div class="form-check">
                                                {!! Form::checkbox('answers[]', 1, false) !!} <label for="">Si</label>
                                                {!! Form::checkbox('answers[]', 0, false) !!} <label for="">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Problemas de coagulacion:</label>
                                            <div class="form-check">
                                                {!! Form::checkbox('answers[]', 1, false) !!} <label for="">Si</label>
                                                {!! Form::checkbox('answers[]', 0, false) !!} <label for="">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Asma:</label>
                                            <div class="form-check">
                                                {!! Form::checkbox('answers[]', 1, false) !!} <label for="">Si</label>
                                                {!! Form::checkbox('answers[]', 0, false) !!} <label for="">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Glandula tiroides:</label>
                                            <div class="form-check">
                                                {!! Form::checkbox('answers[]', 1, false) !!} <label for="">Si</label>
                                                {!! Form::checkbox('answers[]', 0, false) !!} <label for="">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Problemas Hepaticos:</label>
                                            <div class="form-check">
                                                {!! Form::checkbox('answers[]', 1, false) !!} <label for="">Si</label>
                                                {!! Form::checkbox('answers[]', 0, false) !!} <label for="">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Cardiacos:</label>
                                            <div class="form-check">
                                                {!! Form::checkbox('answers[]', 1, false) !!} <label for="">Si</label>
                                                {!! Form::checkbox('answers[]', 0, false) !!} <label for="">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="">Pulmonares:</label>
                                            <div class="form-check">
                                                {!! Form::checkbox('answers[]', 1, false) !!} <label for="">Si</label>
                                                {!! Form::checkbox('answers[]', 0, false) !!} <label for="">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header" id="no_patologico">
                    <h5>
                        <input type="button" class="btn-link" data-toggle="collapse" data-target="#collapseTwo"
                            aria-expanded="false" aria-controls="collapseTwo"
                            value="Antecedentes Personales No Patologicos">
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="no_patologico" data-parent="#accordion">
                    <div class="card-body">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="">
                                    Fuma
                                    <input type="button" value="?" class="btn btn-secondary btn-sm"
                                        data-container="body" data-toggle="popover" data-placement="top"
                                        data-content="En caso de ser No la respuesta, dejarlo en blanco.">
                                    :
                                </label>
                                {!! Form::text('answers[]', null, [
                                    'class' => 'form-control',
                                    'id' => 'cig_id',
                                    'placeholder' => 'Cuantos cigarrillos al dia',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="">
                                    Has recibido tratamiento medico ultimamente
                                    <input type="button" value="?" class="btn btn-secondary btn-sm"
                                        data-container="body" data-toggle="popover" data-placement="top"
                                        data-content="En caso de ser No la respuesta, dejarlo en blanco.">
                                    :
                                </label>
                                {!! Form::text('answers[]', null, [
                                    'class' => 'form-control',
                                    'id' => 'trat_id',
                                    'placeholder' => 'Especifique',
                                ]) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="">
                                    Toma medicamentos para dormir o para los nervios
                                    <input type="button" value="?" class="btn btn-secondary btn-sm"
                                        data-container="body" data-toggle="popover" data-placement="top"
                                        data-content="En caso de ser No la respuesta, dejarlo en blanco.">
                                    :
                                </label>
                                {!! Form::text('answers[]', null, [
                                    'class' => 'form-control',
                                    'id' => 'sleep_id',
                                    'placeholder' => 'Especifique',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header" id="datos_medicos">
                    <h5>
                        <input type="button" class="btn-link" data-toggle="collapse" data-target="#collapseThree"
                            aria-expanded="false" aria-controls="collapseThree" value="Datos Medicos">
                    </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="datos_medicos" data-parent="#accordion">
                    <div class="card-body">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="">Tipo de Cirugia:</label>
                                {!! Form::text('answers[]', null, ['class' => 'form-control', 'id' => 'cirugia']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="">Fecha de Cirugia:</label>
                                {!! Form::date('answers[]', null, ['class' => 'form-control', 'id' => 'date_cirugia']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="">Nombre del Medico:</label>
                                {!! Form::text('answers[]', null, ['class' => 'form-control', 'id' => 'nom_medico']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="">Tel. de contacto de Medico:</label>
                                {!! Form::text('answers[]', null, ['class' => 'form-control', 'id' => 'tel_med']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="">Numero de Sesiones Recomendadas:</label>
                                {!! Form::text('answers[]', null, ['class' => 'form-control', 'id' => 'sesiones']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="">Area a tratar:</label>
                                {!! Form::text('answers[]', null, ['class' => 'form-control', 'id' => 'sesiones']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="">Primera Sesion:</label>
                                {!! Form::date('answers[]', null, ['class' => 'form-control', 'id' => 'one_sesion']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="">Segunda Sesion:</label>
                                {!! Form::date('answers[]', null, ['class' => 'form-control', 'id' => 'two_sesion']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="">Tercera Sesion:</label>
                                {!! Form::date('answers[]', null, ['class' => 'form-control', 'id' => 'three_sesion']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="">Nombre del Terapeuta:</label>
                                {!! Form::text('answers[]', null, ['class' => 'form-control', 'id' => 'terapeuta']) !!}
                            </div>
                        </div>
                        <hr>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="">Observaciones</label>
                                {!! Form::textarea('answers[]', null, [
                                    'class' => 'form-control',
                                    'id' => 'observacion',
                                    'rows' => '5',
                                    'cols' => '50',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-3 col-sm-3 col-md-3">
            <div class="form-group d-flex">
                <div class="p-2">
                    <button class="btn btn-primary" id="saveBtn" type="submit">Guardar</button>
                </div>
                <div class="p-2">
                    <input type="hidden" id="urlIndex" value="{{ route('socios.index') }}">
                    <input type="button" class="btn btn-success" id="backBtn" value="Regresar lista de socios">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //---------------------------------
    //  Ficha Tecnica Modal
    //---------------------------------
    var modal = document.getElementById("fichaModal");
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];
    var saveBtn = document.getElementById('saveBtn');
    var backBtn = document.getElementById('backBtn');

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    backBtn.disabled = true;
    saveBtn.onclick = function(event) {
        backBtn.disabled = false;
    }

    backBtn.onclick = function(event) {
        location.replace(document.getElementById('urlIndex').value);
    }
</script>
