<tbody id="tableProductos">
    @forelse ($productos as $producto)
        <tr>
            <td style="display: none">{{ $producto->id }}</td>
            <td>{{ $producto->bar_code }}</td>
            <td>{{ $producto->name }}</td>
            <td>{{ $producto->mark }}</td>
            <td>{{ $producto->category }}</td>
            <td>
                @if ($producto->costos)
                    <a href="{{ route('costos.ver',$producto->id) }}" class="btn btn-secondary">Ver</a>
                @else
                    <p>Sin costoso</p>
                @endif
                <a href="{{ route('costos.crear',$producto->vendor_id) }}" class="btn btn-warning">Agregar</a>
            </td>
            <td>{{ $producto->stock }}</td>
            <td>{{ $producto->vendor }}</td>
            <td>{{ $producto->office }}</td>
            <td>
                @can('editar-productos')
                    <a href="{{ route('productos.edit',$producto->id) }}" class="btn btn-info">Editar</a>
                @endcan
            </td>
            <td>
                @can('borrar-productos')
                    <a href="{{ route('productos.destroy',$producto->id) }}" class="btn btn-danger">Borrar</a>
                @endcan
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="10">Sin registros</td>
        </tr>
    @endforelse
    {{ $productos->appends(['search'=>$search,'option'=>$option]) }}
</tbody>