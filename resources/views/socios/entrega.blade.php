<html>

<head>

    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial, Helvetica, sans-serif;
        }

        .profile_cred {
            width: 25mm;
            height: 30mm;
            position: absolute;
            left: 5mm;
            top: 13mm;
            border-radius: 5px;
        }

        #background_cred {
            position: absolute;
            left: 0;
            top: 0;
            width: 85mm;
            height: 54mm;
        }

        #background_cred2 {
            width: 85mm;
            height: 54mm;
        }

        .socio_cred {
            position: absolute;
            right: 5mm;
            bottom: 3mm;
            width: 43mm;
            font-size: 13pt;
            text-align: right;
            font-weight: 700;
            text-shadow: rgba(0, 0, 0, 0.75) 2px 2px 5px;
            color: #fff;
        }

        .phone_cred {
            position: absolute;
            left: 4mm;
            bottom: 2mm;
            font-size: 10pt;
            color: #ffffff;
        }

        .firma_cred {
            position: absolute;
            right: 5mm;
            bottom: 8mm;
            border: #444444 solid 1px;
            border-radius: 2mm;
            padding: 2mm;
            width: 30mm;
            background: white
        }

        .qr_cred {
            position: absolute;
            left: 5mm;
            bottom: 5mm;
            text-align: center;
            width: 23mm;
            height: 23mm;
        }

        .qr_cred img {
            width: 23mm;
            height: 23mm;
        }

        .num_socio {
            position: absolute;
            bottom: 5mm;
            left: 15mm;
            text-align: center;
            transform: rotate(-90deg);
            color: #444444;
            font-family: Arial, Helvetica, sans-serif;
            /* font-weight: 600; */
        }
    </style>
</head>

<body>
    <div>
        <img class="profile_cred" src="data:image/png;base64,{{ $partnerData->foto }}" alt="Red dot" />
        <img src="{{ asset('/img/anverso.png?v1') }}" id="background_cred" />
        <p class="socio_cred">
            {{ $partnerData->name . ' ' . $partnerData->last_name . ' ' . $partnerData->second_lastname }}
        </p>
        <span class="phone_cred">Tel: {{ $partnerData->phone }}</span>
    </div>
    <div>
        <img id="background_cred2" src="{{ asset('/img/reverso.png?v1') }}" />
        <div class="qr_cred">
            <img src="data:image/png;base64,{!! base64_encode(
                QrCode::size(100)->format('png')->generate($partnerData->num_socio),
            ) !!}" alt="">
            <br>
            <p class="num_socio">{{ $partnerData->num_socio }}</p>
        </div>
        <img class="firma_cred" src="{{ $partnerData->firma }}">
    </div>
</body>

</html>
