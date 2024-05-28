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
        width: 21%;
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

{{-- <a class="btn btn-warning" id="Btn"><i class="bi bi-qr-code"></i></a>

<div id="QRModal" class="modal">
    <div class="modal-content">
        <span class="close closeQRModal">&times;</span>
        <div class="card-body">
            {!! QrCode::size(200)->generate($partner->num_socio . ',' . $partner->name) !!}
        </div>
    </div>
</div> --}}

<a class="btn btn-warning" data-toggle="modal" data-target="#QRModal"><i class="bi bi-qr-code"></i></a>
