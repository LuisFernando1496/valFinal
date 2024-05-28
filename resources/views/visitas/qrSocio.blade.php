<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap');

    #cred {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .profile_cred {
        width: 180px;
        height: 180px;
        border: 5px solid rgb(226, 226, 226);
        border-radius: 50%;
        filter: drop-shadow(2px 2px 5px rgba(0, 0, 0, 0.5));
    }

    .socio_cred,
    .num_socio,
    .phone_cred,
    .motiv_desert {
        font-size: 12pt;
        text-align: left;
        font-weight: 600;
    }

    .firma_cred {
        border: #c0c0c0 solid 1px;
        border-radius: 2mm;
        padding: 2mm;
        width: 30mm;
    }

    .status {
        position: absolute;
        top: 150px;
        left: calc(50% - 40px);
        text-align: center;
        width: 80px;
        border: 5px solid rgb(226, 226, 226);
        filter: drop-shadow(2px 2px 5px rgba(0, 0, 0, 0.5));
    }

    .modal-header {
        padding-bottom: 30px;
    }

    .regist {
        position: absolute;
        bottom: 0;
        right: 0;
    }

    .modal {
        z-index: 1024;
    }
</style>

<div class="modal fade" id="QRLector" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Registrar Entrada</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="cred">
                <div class="row w-100">
                </div>
            </div>
        </div>
    </div>
</div>
