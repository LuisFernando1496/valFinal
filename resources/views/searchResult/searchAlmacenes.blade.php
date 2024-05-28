<tbody id ="tableAlmacenes">
    @forelse ($almacenes as $almacen)
        <tr>
            <td style="display: none;">{{ $almacen->id }}</td>
            <td>{{ $almacen->title }}</td>
            <td>{{ $almacen->business->name }}</td>
            <td>{{ $almacen->user->name }} {{ $almacen->user->last_name }} {{ $almacen->user->second_last_name }}</td>
            <td>
                <a href="{{ route('inventario.show',$almacen->id) }}" class="btn btn-primary">Inventario</a>
            </td>
            <td>
                @can('editar-almacenes')
                    <a href="{{ route('almacenes.edit',$almacen->id) }}" class="btn btn-info">Editar</a>
                @endcan
            </td>
            <td>
                @can('borrar-almacenes')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['almacenes.destroy',$almacen->id], 'style' => 'display:inline']) !!}
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
    {{ $almacenes->appends(['search'=>$search,'option'=>$option]) }}
</tbody>