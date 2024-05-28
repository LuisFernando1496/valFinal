<tbody id="tableNegocios">
    @forelse ($negocios as $negocio)
        <tr>
            <td style="display: none">{{$negocio->id}}</td>
            <td>{{ $negocio->name }}</td>
            <td>{{ $negocio->rfc }}</td>
            <td>{{ $negocio->legal_representative }}</td>
            <td>{{ $negocio->number }}</td>
            <td>
                <a href="{{ route('negocios.edit',$negocio) }}" class="btn btn-info">Editar</a>
            </td>
            <td>
                {!!Form::open(['method' => 'DELETE', 'route' => ['negocios.destroy',$negocio], 'style' => 'display:inline']) !!}
                    {!! Form::submit('Borrar',['class' => 'btn btn-danger']) !!}
                {!!Form::close() !!}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7">Sin registros</td>
        </tr>
    @endforelse
        {{ $negocios->appends(['search'=>$search,'option'=>$option]) }}
</tbody>