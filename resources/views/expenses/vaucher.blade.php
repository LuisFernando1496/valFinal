<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    @if ($expense->category_of_expense_id == 6)
        <title>Vale</title>
    @else
        <title>Pago de nomina </title>
    @endif
</head>

<body>

    <style>
        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;

        }



        .left {
            margin-left: 0px;
            margin-right: auto;
            margin-top: 0%;
            padding-top: 0%;
        }

        td,
        tr,
        table {

            border-collapse: collapse;
        }

        td.cantidad,
        th.cantidad {
            word-break: break-all;
        }

        td.precio,
        th.precio {
            word-break: break-all;
        }

        .centrado {
            text-align: center;
            align-content: center;
            width: 100%;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        table.borde {

            border-collapse: collapse;
        }


        @media print {

            .oculto-impresion,
            .oculto-impresion * {
                display: none !important;
            }
        }
    </style>

    <div>
        <table class="borde" style="width: 100%">
            <thead>
                <th class="borde"> <img src="{{ asset('img/logo_val.jpeg') }}" alt="Logotipo"
                        style="width: 50px; height:50px"></th>
                <th>
                    <p class="centrado">

                        Direccion


                    </p>
                </th>
                <th>
                    Fecha:<br>
                    Folio: {{ $expense->id }} <br>
                </th>
            </thead>
        </table>
        <br>
        <br>
        <br>



        <section style="display: flex; justify-content: space-between; align-items: center;">
            <table style="width: 100%">
                <tr>
                    <thead style="font-size: 80%">
                        <th>Nombre</th>
                        @if ($expense->owner_id)
                            <th>Telefono</th>
                        @else
                            <th>Correo</th>
                        @endif
                        <th>Tipo de gasto</th>
                        <th>Descripcion</th>
                        <th>Fecha</th>
                    </thead>
                    <hr>
                </tr>
                <tbody style="text-align: center;font-size: 76%">


                    <tr>
                        @if ($expense->owner_id)
                            <td>{{ $expense->owner->owner_name }}</td>
                            <td>{{ $expense->owner->owner_phone }}</td>
                        @else
                            <td>{{ $expense->userEmpleado->name }}</td>
                            <td>{{ $expense->userEmpleado->email }}</td>
                        @endif
                        <td>{{ $expense->title }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>{{ Carbon\Carbon::parse($expense->date)->format('d-m-y h:m:s') }}</td>

                    </tr>

                </tbody>
            </table>

        </section>
        <br>
        <br>
        <div id="total">

            <br>
            Total: ${{ number_format($expense->total, 2, '.', ',') }}
        </div>
        <hr>
        <br />
        <br />
        <p class="centrado">_____________________________</p>
        <p class="centrado">Firma</p>
        <br />
        <br />
        <br />


    </div>
</body>
<script>
    window.print();
    window.addEventListener("afterprint", function(event) {
        window.close()
    });
</script>

</html>
