<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance_Partner;
use App\Models\Partners;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $registers = Attendance_Partner::paginate(10);
        return view('home', compact('registers'));
    }

    public function store(Request $request)
    {
        $numSocio = explode(',', $request->num_socio);
        
        $nombre = Partners::select('name')->where('num_socio', $numSocio[0])->get()->pluck('name');
        $nombre = $nombre[0];
        $apellido = Partners::select('last_name')->where('num_socio', $numSocio[0])->get()->pluck('last_name');
        $apellido = $apellido[0];
        $s_apellido = Partners::select('second_lastname')->where('num_socio', $numSocio[0])->get()->pluck('second_lastname');
        $s_apellido = $s_apellido[0];

        $history = new Attendance_Partner;
        $history->date = Carbon::now();
        $history->num_socio = $numSocio[0];
        $history->name = $nombre;
        $history->lastname = $apellido;
        $history->second_lastname = $s_apellido;
        $history->save();
        
        return back();
    }
}
