<tbody id="tableCreditos">
    @forelse ($creditos as $credito)
    <tr>
        
        <td>{{$credito->client}}</td>
        <td>${{$credito->amount}}</td>
        <td>${{$credito->available}}</td>
        <td>{{$credito->created_at}}</td>
        <td>
                @can('editar-creditos')
                    <a href="{{ route('historyShop',$credito->client) }}" class="btn btn-info">ver compras</a>
                   
                    @endcan
            </td>
            <td>
            @can('editar-creditos')
                    <a href="{{ route('creditos.edit',$credito) }}" class="btn btn-warning">Editar</a>
                    @endcan
            </td>
            <td>
            @can('borrar-creditos')
                    {!! Form::open(['method' => 'DELETE', 'route' => ['creditos.destroy',$credito->id], 'style' => 'display:inline']) !!}
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
    {{ $creditos->appends(['search'=>$search,'option'=>$option]) }}
</tbody>