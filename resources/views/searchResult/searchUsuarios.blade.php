<tbody id="Usuarios">
    @forelse ($users as $user)
        <tr>
            <td style="display: none;">{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->last_name }}</td>
            <td>{{ $user->second_last_name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->office ?? '' }}</td>
            <td>
                @if (!empty($user->getRoleNames()))
                    @foreach ($user->getRoleNames() as $rolName)
                        <h5><span class="badge badge-dark">{{ $rolName }}</span></h5>
                    @endforeach
                @endif
            </td>
            <td>
                <a href="{{ route('usuarios.edit',$user->id) }}" class="btn btn-info">Editar</a>
            </td>
            <td>
                {!! Form::open(['method' => 'DELETE', 'route' => ['usuarios.destroy',$user->id], 'style' => 'display:inline']) !!}
                    {!! Form::submit('Borrar', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8">Sin registros</td>
        </tr>
    @endforelse
    {{ $users->appends(['search'=>$search,'option'=>$option]) }}
</tbody>