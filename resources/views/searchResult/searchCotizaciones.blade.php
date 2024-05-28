<tbody id="tableCotizaciones">
    @forelse ($cotizaciones as $cotizacion)
        <tr>
            <td style="display: none;">{{ $cotizacion->id }}</td>
            <td>{{ $cotizacion->folio }}</td>
            <td>
                @if ($cotizacion->cliente != null)
                    {{ $cotizacion->cliente }}
                @else
                    {{ $cotizacion->client->name }} {{ $cotizacion->client->last_name }} {{ $cotizacion->client->second_last_name }}
                @endif
            </td>
            <td>${{ $cotizacion->total }}</td>
            <td>{{ $cotizacion->date }}</td>
            <td>{{ $cotizacion->usercash->user->name }} {{ $cotizacion->usercash->user->last_name }}</td>
            <td>
                <a href="{{ route('cotizaciones.show',$cotizacion->id) }}" class="btn btn-info">Detalles</a>
            </td>
            <td>
                <a href="{{ route('cotizaciones.edit',$cotizacion->id) }}" class="btn btn-success">Vender</a>
            </td>
            <td>
                <a href="{{ route('cotizaciones.imprimir',$cotizacion->id) }}" class="btn btn-dark" target="blank">Imprimir</a>
            </td>
            <td>
                @can('borrar-cotizaciones')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['cotizaciones.destroy',$cotizacion->id], 'style' => 'display:inline']) !!}
                        {!! Form::submit('Cancelar', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                @endcan
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="10"> Sin Resultados</td>
        </tr>
    @endforelse
    {{ $cotizaciones->appends(['search'=>$search,'option'=>$option]) }}
</tbody>