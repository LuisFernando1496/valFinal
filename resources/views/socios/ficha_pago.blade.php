<div class="modal fade" id="fichaModal" tabindex="-2" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Ficha pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="form-group">
                            <label for="pago_anualidad">Anualidad: </label>
                            {{-- <span class="badge badge-success badge-pill"> Pagado</span> --}}
                            <span class="badge badge-warning badge-pill"> Pendiente</span>
                            <input type="number" class="form-control" id="pago_anualidad" value="400" readonly>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="form-group">
                            <label for="pago_mensualidad">Mensualidad: </label>
                            {{-- <span class="badge badge-success badge-pill"> Pagado</span> --}}
                            {{-- <span class="badge badge-warning badge-pill"> Recargo</span> --}}
                            {{-- <input type="number" class="form-control" id="pago_mensualidad" value="1580"> --}}
                            {{-- <span class="badge badge-danger badge-pill"> Sanción</span> --}}
                            {{-- <input type="number" class="form-control" id="pago_mensualidad" value="3000"> --}}
                            <span class="badge badge-info badge-pill"> Por Renovar</span>
                            <input type="number" class="form-control" id="pago_mensualidad" value="1500" readonly>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-10 mt-4 text-right">
                        <label for="desc_anualidad">Promoción 12x1: </label>
                    </div>
                    <div class="col-md-1 col-2 mt-3 text-left">
                        <input type="checkbox" id="desc_anualidad" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="saveBtn" type="submit">Guardar</button>
                <input type="hidden" id="urlIndex" value="{{ route('socios.index') }}">
                <input type="button" class="btn btn-success" id="backBtn" value="Ver Pagos">
            </div>
        </div>
    </div>
</div>


{{-- <script>
    //---------------------------------
    //  Ficha Tecnica Modal
    //---------------------------------
    var modalPago = document.getElementById("fichaModal");
    var btnPago = document.getElementById("myBtn");
    var spanPago = document.getElementsByClassName("close")[0];
    var saveBtnPago = document.getElementById('saveBtn');
    var backBtnPago = document.getElementById('backBtn');

    btnPago.onclick = function() {
        modalPago.style.display = "block";
    }

    spanPago.onclick = function() {
        modalPago.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modalPago) {
            modalPago.style.display = "none";
        }
    }

    backBtnPago.disabled = true;
    saveBtnPago.onclick = function(event) {
        backBtnPago.disabled = false;
    }

    backBtnPago.onclick = function(event) {
        location.replace(document.getElementById('urlIndex').value);
    }
</script> --}}
