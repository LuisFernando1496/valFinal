@extends('layouts.app')

@section('content')



    <section class="section">
        <div class="section-header">
            <h3 class="page__heading ">Historial de compras</h3>
        </div>
        <div class="section-body">
            <h4 class="page__heading"><strong> {{ $client->fullname() }} </strong></h4>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="display: none;">ID</th>
                                    <th style="color: #fff;">Folio</th>
                                    <th style="color: #fff;">Metodo Pago</th>
                                    <th style="color: #fff;">Total</th>
                                    <th style="color: #fff;">Abono</th>
                                    <th style="color: #fff;">Saldo restante</th>
                                    <th style="color: #fff;">Saldo anterior</th>
                                    <th style="color: #fff;">Fecha</th>
                                    <th style="color: #fff;">Abono</th>
                                    <th style="color: #fff;">Detalles</th>
                                    <th style="color: #fff;">Ticket</th>
                                    <th style="color: #fff;">Cancelar</th>
                                </thead>
                                <tbody>
                                    
                                    @forelse ($clientShop as $v=>$venta)
                                        <tr>
                                            
                                            <td style="display: none;">{{ $venta->id }}</td>
                                            <td>{{ $venta->folio }} </td>
                                            <td>{{ $venta->method }}</td>
                                            <td>${{ $venta->total }}
                                            </td>
                                            @if (sizeof($venta->payments))
                                                @if( $venta->payments[0]->remaining == 0)   
                                                    <td>Pagado</td>
                                                    <td>---</td>
                                                    <td>---</td>
                                                @else
                                                <td>${{ $venta->payments[0]->amount }}</td>
                                                <td>${{ $venta->payments[0]->remaining }}</td>
                                                <td>${{ $venta->payments[0]->remaining + $venta->payments[0]->amount }}</td>
                                                
                                                @endif
                                            @else
                                             
                                              <td>Pagado</td>
                                              <td>--</td>
                                              <td>---</td>
                                            @endif

                                            <td>{{ $venta->date }}</td>
                                            @if (sizeof($venta->payments))
                                                @if( $venta->payments[0]->remaining != 0)   
                                                <td> @can('editar-creditos')
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#amounModal{{$venta->id}}">
                                                        Abonar
                                                    </button>
                                                    @endcan
                                                </td>
                                            
                                            @else
                                            <td>@can('editar-creditos')
                                                <button type="button" class="btn btn-primary" onclick="comprobante(id = {{$venta->id}})" >
                                                    Descargar comprobante
                                                </button>
                                                @endcan</td>
                                            
                                            @endif
                                           
                                         @else
                                         
                                          <td>---</td>
                                        @endif
                                          
                                           
                                          
                                            <td>
                                                @can('ver-ventas')
                                                    <a href="{{ route('detalles-abonos', $venta->id) }}"
                                                        class="btn btn-info">Detalles</a>
                                                @endcan
                                            </td>
                                            <td>
                                                @can('ver-ventas')
                                                    <a href="{{ route('ventas.ticket', $venta->id) }}" target="blank"
                                                        class="btn btn-primary">Ticket</a>
                                                @endcan
                                            </td>
                                            <td>
                                                @can('borrar-ventas')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['ventas.destroy', $venta->id], 'style' => 'display:inline']) !!}
                                                    {!! Form::submit('Cancelar', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">Sin registros</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @forelse ($clientShop as $venta)
    <div class="modal fade" id="amounModal{{$venta->id}}" tabindex="-1" aria-labelledby="amounModal{{$venta->id}}Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">{{$venta->folio}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
            <div class="modal-body">
                {!! Form::open(array('route' => ['abonoCredit',$venta->id], 'method' => 'POST', 'id'=>'formulario','target'=>'ventanaTicket')) !!}
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="country">Abono</label>
                            {!! Form::number('amount', NULL, array('class' => 'form-control', 'step' =>'any', 'placeholder' => '$')) !!}
                        </div>
                    </div>
                    </div>
                    {!! Form::close() !!}
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" onclick="abonar(event)" class="btn btn-primary">Confirmar</button>
              
            </div>
          </div>
        </div>
      </div>
      @empty
    @endforelse
   
    <script>
        const abonar = (event) =>
        {
           event.preventDefault();
           window.open('','ventanaTicket');
           document.getElementById('formulario').submit();
           window.location.reload();
        }
        const comprobante = (id) =>
        {
            window.open(`/creditos/historial-compras/creditos/comprobante/${id}`);  
        }
      
    </script>
@endsection
