<style>
    .drop-container {
        border-radius: .25rem;
        border: 1px solid #e4e6fc;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .labelWeb {
        font-weight: 600;
        color: #34395e;
        font-size: 12px;
        letter-spacing: .5px;
    }

    #myCamera {
        width: 192px !important;
        /* margin-bottom: 5px; */
        height: auto !important;
    }

    video {
        /* height: auto !important; */
        width: 100%;
        height: 132px !important;
        border-radius: 0.25rem;
        border: 1px solid #e4e6fc;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    #results img {
        border-radius: 0.25rem;
        border: 1px solid #e4e6fc;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    ul.nav-tabs li.nav-item a.nav-link.active i {
        color: #ffffff;
    }
</style>
<div class="row">
    <div class="col-xl-4 col-md-8">
        <ul class="nav nav-pills nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#menu1">
                    <i class="fas fa-camera"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#menu2">
                    <i class="fas fa-image"></i>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="menu1" class="tab-pane active">
                <div class="row">
                    <div class="col-md-6">
                        <div id="myCamera"></div>
                        <input type="button" class="btn btn-success" onClick="takeSnapshot();" value="Tomar Foto" />
                    </div>
                    <div class="col-md-6">
                        <div id="results"></div>
                        <div id="text" class="d-none"></div>
                    </div>
                </div>
            </div>
            <div id="menu2" class="tab-pane fade">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-warning" style="z-index: 0;" id="showFile2" type="button">Subir
                            Archivo</button>
                    </div>
                    <input type="text" id="nameFile2" class="form-control" placeholder="Nombre de Archivo" readonly>
                </div>
                <input type="file" class="d-none" name="image" id="upload_photo">
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <label class="labelWeb">Es necesario leer los documentos antes de firmar:</label>
        <br>
        <ul>
            <li><a target="_blank" href="{{ asset('files/REGLAMENTO.pdf') }}">
                    <span style="text-decoration: underline var(--secondary);">Aviso de Términos y Condiciones.</span>
                </a></li>
            <li><a target="_blank" href="{{ asset('files/REGLAMENTO.pdf') }}">
                    <span style="text-decoration: underline var(--secondary);">Aviso de Privacidad.</span>
                </a></li>
            <li><a target="_blank" href="{{ asset('files/REGLAMENTO.pdf') }}">
                    <span style="text-decoration: underline var(--secondary);">Reglamento.</span>
                </a></li>
            {{-- <li><a target="_blank" href="{{ asset('files/REGLAMENTO.pdf') }}">
                    <span style="text-decoration: underline var(--secondary);">Ficha Técnica.</span>
                </a></li> --}}
        </ul>
    </div>
    <div class="col-xl-4 col-md-6">
        <label class="labelWeb">Firma Caligráfica</label>

        <br>
        <canvas id="canvas" class="drop-container"></canvas>
        <br>
        <input type="button" class="btn btn-success" id="btnDescargar" value="Guardar" />
        <input type="button" class="btn btn-secondary" id="btnLimpiar" value="Limpiar" />
        <input type="hidden" name="signData" id="signData">
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
<script>
    var showFile2 = document.getElementById("showFile2");
    var nameFile2 = document.getElementById("nameFile2");
    var dataFile2 = document.getElementById("upload_photo");
    showFile2.onclick = function() {
        dataFile2.click();
        dataFile2.onchange = function() {
            nameFile2.value = dataFile2.files[0].name;
        }
    }
</script>
<script>
    //-----------------------------------
    //Firma Digital
    //-----------------------------------
    const $canvas = document.getElementById('canvas');
    const $btnDescargar = document.getElementById('btnDescargar');
    const $btnLimpiar = document.getElementById('btnLimpiar');
    const $signSave = document.getElementById('signData');
    const contexto = $canvas.getContext('2d');
    const COLOR_PINCEL = '#000000';
    const COLOR_FONDO = '#FFFFFF';
    const GROSOR = 1.5;
    let xAnterior = 0,
        yAnterior = 0,
        xActual = 0,
        yActual = 0;
    const obtenerXReal = (clientX) => clientX - $canvas.getBoundingClientRect().left;
    const obtenerYReal = (clientY) => clientY - $canvas.getBoundingClientRect().top;
    let haComenzadoDibujo = false;
    $canvas.addEventListener("mousedown", evento => {
        // En este evento solo se ha iniciado el clic, así que dibujamos un punto
        xAnterior = xActual;
        yAnterior = yActual;
        xActual = obtenerXReal(evento.clientX);
        yActual = obtenerYReal(evento.clientY);
        contexto.beginPath();
        contexto.fillStyle = COLOR_PINCEL;
        contexto.fillRect(xActual, yActual, GROSOR, GROSOR);
        contexto.closePath();
        // Y establecemos la bandera
        haComenzadoDibujo = true;
    });

    $canvas.addEventListener("mousemove", (evento) => {
        if (!haComenzadoDibujo) {
            return;
        }
        // El mouse se está moviendo y el usuario está presionando el botón, así que dibujamos todo

        xAnterior = xActual;
        yAnterior = yActual;
        xActual = obtenerXReal(evento.clientX);
        yActual = obtenerYReal(evento.clientY);
        contexto.beginPath();
        contexto.moveTo(xAnterior, yAnterior);
        contexto.lineTo(xActual, yActual);
        contexto.strokeStyle = COLOR_PINCEL;
        contexto.lineWidth = GROSOR;
        contexto.stroke();
        contexto.closePath();
    });
    ["mouseup", "mouseout"].forEach(nombreDeEvento => {
        $canvas.addEventListener(nombreDeEvento, () => {
            haComenzadoDibujo = false;
        });
    });

    const limpiarCanvas = () => {
        // Colocar color blanco en fondo de canvas
        contexto.fillStyle = COLOR_FONDO;
        contexto.fillRect(0, 0, $canvas.width, $canvas.height);
    };
    limpiarCanvas();
    $btnLimpiar.onclick = limpiarCanvas;
    $btnDescargar.onclick = () => {
        $("#signData").val($canvas.toDataURL());
        alert('Firma Guardada');
    };

    //----------------------------------
    // Captura de foto
    //----------------------------------
    Webcam.set({
        width: 190,
        height: 190,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach('#myCamera');

    function takeSnapshot() {
        Webcam.snap(function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
            document.getElementById('text').innerHTML =
                '<input type="text" id="image-tag" name="image-tag" value="' + data_uri + '"/>';
        });
    }
</script>
