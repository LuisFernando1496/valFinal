<tbody id="tableClientes">
    @forelse ($clientes as $cliente)
        <tr>
            <td style="display: none;">{{ $cliente->id }}</td>
            <td>{{ $cliente->name }}</td>
            <td>{{ $cliente->last_name }}</td>
            <td>{{ $cliente->second_last_name }}</td>
            <td>{{ $cliente->email }}</td>
            <td>{{ $cliente->office }}</td>
            <td>
                @can('editar-clientes')
                    <a href="{{ route('clientes.edit',$cliente->id) }}" class="btn btn-info">Editar</a>
                @endcan
            </td>
            <td>
                @can('borrar-clientes')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['clientes.destroy',$cliente->id], 'style' => 'display:inline']) !!}
                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                @endcan
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="11">Sin registros</td>
        </tr>
    @endforelse
    {{ $clientes->appends(['search'=>$search,'option'=>$option]) }}
</tbody>