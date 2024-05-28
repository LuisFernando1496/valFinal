<div class="section-body" style="margin-top: 100px">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table text-nowrap table-striped table-hover mt-2" id="visit">
                            <thead style="background-color: #6777ef;">
                                <th style="display: none;">ID</th>
                                <th style="color: #fff;">Numero de cliente</th>
                                <th style="color: #fff;">Nombre Completo</th>
                                <th style="color: #fff;" class="text-center">Fecha</th>
                                <th style="color: #fff;" class="text-center">Entrada</th>
                                <th style="color: #fff;" class="text-center">Salida</th>
                            </thead>
                            <tbody id="tableSucursales">
                                @forelse ($visits as $data)
                                    <tr>
                                        <td style="display: none;">{{ $data->id }}</td>
                                        <td>{{ $data->num_socio }}</td>
                                        <td>{{ $data->name }} {{ $data->last_name }}
                                            {{ $data->second_lastname }}</td>
                                        <td class="text-center">{{ explode(' ', $data->entrada)[0] }}</td>
                                        <td class="text-center">{{ explode(' ', $data->entrada)[0] }}</td>
                                        <td class="text-center">{{ explode(' ', $data->salida)[0] }}</td>
                                    </tr>
                                @empty
                                @endforelse
                                <tr class='noSearch hide'>
                                    <td colspan="5">Se ha encontrado {{ count($visits) }}
                                        coincidencia{{ count($visits) > 1 ? 's' : '' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- <div class="pagination" id="pag">
                    {{ $visits->links() }}
                </div> --}}
            </div>
        </div>
    </div>
</div>
