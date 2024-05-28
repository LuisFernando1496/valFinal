<tbody id="tableCategorias">
    @forelse ($categorias as $categoria)
        <tr>
            <td style="display: none;">{{ $categoria->id }}</td>
            <td>{{ $categoria->name }}</td>
            <td>{{ $categoria->description }}</td>
            <td>{{ $categoria->office }}</td>
            <td>
                @can('editar-categoria')
                    <a href="{{ route('categorias.edit',$categoria->id) }}" class="btn btn-info">Editar</a>
                @endcan
            </td>
            <td>
                @can('borrar-categoria')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['categorias.destroy',$categoria->id], 'style' => 'display:inline']) !!}
                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                @endcan
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6">Sin registros</td>
        </tr>
    @endforelse
</tbody>
{{ $categorias->appends(['search'=>$search,'option'=>$option]) }}
</table>