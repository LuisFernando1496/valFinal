<tbody id="tableProveedores">
    @forelse ($vendors as $vendor)
        <tr>
            <td style="display: none;">{{ $vendor->id }}</td>
            <td>{{ $vendor->name }}</td>
            <td>{{ $vendor->phone }}</td>
            <td>{{ $vendor->email }}</td>
            <td>{{ $vendor->address }}. </td>
            <td>{{ $vendor->office}}</td>
            <td>
                @can('editar-proveedor')
                    <a href="{{ route('proveedores.edit',$vendor->id) }}" class="btn btn-info">Editar</a>
                @endcan
            </td>
            <td>
                @can('borrar-proveedor')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['proveedores.destroy',$vendor->id], 'style' => 'display:inline']) !!}
                        {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                @endcan
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8">Sin registros</td>
        </tr>
    @endforelse
    {{ $vendors->appends(['search'=>$search,'option'=>$option]) }}
</tbody>