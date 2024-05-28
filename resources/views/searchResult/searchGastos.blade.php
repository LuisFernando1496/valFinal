<tbody id="tableGastos">
    @forelse ($expenses as $gasto)
    @php
        $title = $gasto->title;
    @endphp
    <tr>
        <td>{{ $gasto->title }}</td>
        <td>{{ $gasto->description }}</td>
        <td><span class="badge badge-info float-center">
            {{ $gasto->tipo }}
        </span></td>
        <td>${{number_format( $gasto->total,2) }}</td>
        <td>{{ $gasto->user }}</td>
        <td>{{ $gasto->office }}</td>
        <td>{{ $gasto->date }}</td>
        <td>
            @if ( $gasto->tipo_id == 6 || $gasto->tipo_id == 7)
                @can('editar-gastos')
                   <a href="{{ route('expenses.edit', $gasto) }}"
                    class="btn btn-info">Vale</a>
                  @endcan
            @else
                
            @endif
           
        </td>
        <td>
           
            @can('editar-gastos')
                <a href="{{route('expenses.edit',$gasto)}}" class="btn btn-warning">Editar</a>
            @endcan
        </td>
        <td>
            @can('borrar-gastos')
                {!! Form::open(['method' => 'DELETE', 'route' => ['expenses.destroy', $gasto],'style' => 'display:inline']) !!}
                {!! Form::submit('Borrar', ['class' => 'btn btn-danger', 'onclick'=>"return confirm('¿Seguro que desea elminar: $title?')" ]) !!}
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
<div class="pagination">
    {{ $expenses->appends(['search'=>$search,'option'=>$option]) }}
</div>