<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Business;
use App\Models\Partners;
use App\Models\Visits;

class VisitsController extends Controller
{

    public function index()
    {
        $visits = Visits::with('partners')->where('entrada', 'like', date("Y-m-d") . '%')->paginate(18);
        return view('visitas.index', compact("visits"));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->id);
        $day = Visits::where('partners_id', $request->id)->where('entrada', 'like', date("Y-m-d") . '%')->first();
        if (empty($day)) {
            Visits::create([
                'partners_id' => $request->id,
                'entrada' => date("Y-m-d H:i:s"),
                'user_id' => \Illuminate\Support\Facades\Auth::user()->id,
            ]);
            return redirect()->route('visitas.index')->with('messageT', 'Socio ha registrado entrada');
        } else {
            return redirect()->route('visitas.index')->with('message', 'Socio ya ha registrado una entrada en el día');
            //echo 'Ya se ha registrado entrada';
        }
    }

    public function show()
    {
        $negocios = Business::pluck('name', 'id')->all();
        return view('visitas.listado', compact("negocios"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $date1 = $request->date1 . ' 00:00:00';
        $date2 = $request->date2 . ' 24:00:00';
        if ($request->date2 == '') {
            $visits = Visits::with('partners')
                ->where('entrada', 'like', $request->date1 . '%')
                ->paginate(18);
        } else {
            $visits = Visits::with('partners')
                ->whereBetween('entrada', [$date1, $date2])
                ->paginate(18);
        }
        //return view('visitas.tblList', compact("visits"));
        //dd($visits);


        $visits = DB::table('visits')
            ->join('partners', 'visits.partners_id', '=', 'partners.id')
            ->join('businesses_partners', 'partners.id', '=', 'businesses_partners.partners_id')
            ->join('businesses', 'businesses_partners.businesses_id', '=', 'businesses.id')
            ->select('visits.*', 'partners.num_socio', 'partners.name', 'partners.last_name', 'partners.second_lastname', 'businesses.name as nameBus', 'businesses.id as idBusinesses')
            ->where('businesses.name', 'Val')
            ->whereBetween('visits.entrada', [$date1, $date2])
            ->paginate(18);
        //->get();

        //var_dump($visits);
        return view('visitas.tblList', compact("visits"));
        //return view('socios.index', compact("partnersVal","partnersAgua"));

    }

    public function edit($id)
    {
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
        $visits = Visits::find($id);
        $visits->salida = date("Y-m-d H:i:s");
        $visits->save();
        return redirect()->route('visitas.index')->with('messageT', 'Se ha registrado la salida correctamente');
    }

    public function getSocioInfo($socio)
    {
        $partnerData = Partners::where('num_socio', $socio)->first();
        //dd($partnerData);
        return view('visitas.modals', compact("partnerData"));
    }
    /* public function qrSocio()
    {
        return view('visitas.qrSocio');
    } */
}
