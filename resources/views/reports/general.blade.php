<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte General</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body class="body-container">
    <div class="container">
        <div class="card mt-2">
            <div class="row g-0">
                <div class="col-md-6">
                    <img src="{{ asset('img/logo.png') }}" class="img-fluid rounded-start" alt="..." style="max-width: 100%">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h5 class="card-title">Reporte General</h5>
                        <p class="card-text"><br></p>
                        <p>Realizado por: <b>{{ Auth::user()->name }} {{ Auth::user()->last_name }} {{ Auth::user()->second_last_name }}</b></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <h5 class="card-title">Productos Agregados</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped mt-2">
                    <thead style="background-color: #6777ef;">
                        <th style="color: #fff;">Producto</th>
                        <th style="color: #fff;">Proveedor</th>
                        <th style="color: #fff;">Stock</th>
                        <th style="color: #fff;">Costos</th>
                        <th style="color: #fff;">Precios</th>
                        <th style="color: #fff;">Categoria</th>
                        <th style="color: #fff;">Fecha</th>
                    </thead>
                    <tbody>
                        @forelse ($productos as $producto)
                            <tr>
                                <td>{{ $producto->product->name }}</td>
                                <td>{{ $producto->vendor->name }}</td>
                                <td>{{ $producto->stock }}</td>
                                <td>
                                    @forelse ($producto->costos as $costo)
                                        ${{ $costo->cost }}
                                        <br>
                                    @empty

                                    @endforelse
                                </td>
                                <td>
                                    @forelse ($producto->costos as $costo)
                                        ${{ $costo->price }}
                                        <br>
                                    @empty

                                    @endforelse
                                </td>
                                <td>{{ $producto->product->category->name }}</td>
                                <td>{{ $producto->updated_at->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Sin productos agregados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mt-2">
            <div class="card-header">
                <h5 class="card-title">Transferencias de Almacen</h5>
            </div>
            <div class="card-body">
                @forelse ($transferencias as $transfer)
                    <div class="row">
                        <div class="col">
                            <h6>{{ $transfer->warehouse->title }}</h6>
                        </div>
                        <div class="col">
                            <h6>Fecha: {{ $transfer->created_at->format('d-m-Y g:i A') }}</h6>
                        </div>
                    </div>
                @empty

                @endforelse
            </div>
        </div>
    </div>
</body>
</html>
