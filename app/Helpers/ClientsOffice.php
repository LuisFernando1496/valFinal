<?php


use App\Models\Client;
use Illuminate\Support\Facades\DB;

function getClients($user)
{

    if ($user->id == 1) {
        $clientes = Client::select(DB::raw("CONCAT(name,' ',last_name,' ',second_last_name)As name"), 'id')->pluck('name', 'id');
    } else {
        $userIdLogged = $user->office_id;
        $clientes = Client::where('office_id', $userIdLogged)
            ->select(DB::raw("CONCAT(name,' ',last_name,' ',second_last_name)As name"), 'id')->pluck('name', 'id');
    }
    return $clientes;
}
