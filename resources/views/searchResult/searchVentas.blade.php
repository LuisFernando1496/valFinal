<tbody id ="tableVentas">
    @forelse ($ventas as $venta)
        <tr>
            <td style="display: none;">{{ $venta->id }}</td>
            <td>{{ $venta->folio }}</td>
            <td>{{ $venta->method }}</td>
            <td>${{ $venta->total }}</td>
            <td>{{ $venta->usercash->user->name }} {{ $venta->usercash->user->last_name }} {{ $venta->usercash->user->second_last_name }}</td>
            <td>{{ $venta->date }}</td>
            <td>
                @can('ver-ventas')
                    <a href="{{ route('ventas.show',$venta->id) }}" class="btn btn-info">Detalles</a>
                @endcan
            </td>
            <td>
                @can('ver-ventas')
                    <a href="{{ route('ventas.ticket',$venta->id) }}" target="blank" class="btn btn-primary">Ticket</a>
                @endcan
            </td>
            <td>
                @can('borrar-ventas')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['ventas.destroy',$venta->id], 'style' => 'display:inline']) !!}
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
    {{ $ventas->appends(['search'=>$search,'option'=>$option]) }}

</tbody>