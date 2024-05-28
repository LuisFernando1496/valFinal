<tbody id="tableServicios">
    @forelse ($servicios as $servicio)
        <tr>
            <td style="display: none;">{{ $servicio->id }}</td>
            <td>{{ $servicio->bar_code }}</td>
            <td>{{ $servicio->name }}</td>
            <td>${{ number_format($servicio->cost,2,'.',',') }}</td>
            <td>${{ number_format($servicio->price,2,'.',',') }}</td>
            <td>{{ $servicio->description }}</td>
            <td>{{ $servicio->office }}</td>
            <td>
                @can('editar-servicios')
                    <a href="{{ route('servicios.edit',$servicio->id) }}" class="btn btn-info">Editar</a>
                @endcan
            </td>
            <td>
                @can('borrar-servicios')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['servicios.destroy',$servicio->id], 'style' => 'display:inline']) !!}
                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                @endcan
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9">Sin registros</td>
        </tr>
    @endforelse
</tbody>
{{ $servicios->appends(['search'=>$search,'option'=>$option]) }}
</table>