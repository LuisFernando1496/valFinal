<tbody id="tableSucursales">
    @forelse ($oficinas as $sucursal)
        <tr>
            <td style="display: none;">{{ $sucursal->id}}</td>
            <td>{{ $sucursal->name }}</td>
            <td>{{ $sucursal->phone }}</td>
            <td>{{ $sucursal->responsable }}</td>
            <td>{{ $sucursal->address }}.</td>
            <td>{{ $sucursal->negocio }}</td>
            <td>
                <a href="{{ route('sucursales.edit',$sucursal) }}" class="btn btn-info">Editar</a>
            </td>
            <td>
                {!! Form::open(['method' => 'DELETE', 'route' => ['sucursales.destroy',$sucursal], 'style' => 'display:inline']) !!}
                    {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            </td>
        </tr>
    @empty
        <tr> 
            <td colspan="8">Sin registros</td>
        </tr>
    @endforelse 
    {{ $oficinas->appends(['search'=>$search,'option'=>$option]) }}
</tbody>
   
