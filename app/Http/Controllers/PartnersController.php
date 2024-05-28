<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mail;

use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as Pdf;

use App\Http\Requests\PartnerFormRequest;

use Illuminate\Support\Facades\DB;
use File;
use Repsonse;
use App\Models\Business;
use App\Models\Partners;
use App\Models\Businesses_partners;
use App\Models\Ficha_Tecnica;
use App\Models\Answer_fTecnica;
use App\Models\Attendance_Partner;

//use App\Mail\Mensaje;

class PartnersController extends Controller
{

    public function index()
    {
        //$partnersVal = Businesses_partners::with('Business')->where('Business.name', 'Val')->paginate(10);
        //$partnersVal = Businesses_partners::with('Businesses')->where('Businesses.name', 'Val')->paginate(10);

        $value = 'Val';
        $partnersVal = Businesses_partners::with(['Businesses', 'Partners'])
            ->whereHas('Businesses', function ($q) use ($value) {
                // Query the name field in status table
                $q->where('name', '=', $value); // '=' is optional
            })
            ->paginate(10);
        
        $value2 = 'Agua';
        $partnersAgua = Businesses_partners::with(['Businesses', 'Partners'])
            ->whereHas('Businesses', function ($q) use ($value2) {
                // Query the name field in status table
                $q->where('name', '=', $value2); // '=' is optional
            })
            ->paginate(10);

        $partners = Partners::paginate(10);
        return view('socios.index', compact("partnersVal","partnersAgua"));
    }


    public function create()
    {
        $negocios = Business::pluck('name', 'id')->all();
        return view('socios.create', compact("negocios"));
    }


    public function store(PartnerFormRequest $request)
    {
        /* $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'age' => 'required',
            'phone' => 'required',
            'phone_emergency' => 'required'
        ]); */

        $rand = rand(10, 90);
        $folio = '';
        $numPartAct = date('ymd');
        $search = Partners::select('num_socio')
            ->where('num_socio', 'LIKE', '%' . $numPartAct . '%')
            ->orderBy('num_socio')
            ->get();

        $busquedafolio = count($search);
        //print_r($busquedafolio);
        if ($busquedafolio < 9) {
            $numFolio = '00';
        } else if ($busquedafolio < 99) {
            $numFolio = '0';
        } else {
            $numFolio = '';
        }
        $numero = intval($busquedafolio);
        $busquedafolio >= 1 ? $folio = $numPartAct . $numFolio . ($numero + 1) : $folio = $numPartAct .
            '001';
        $partners = new Partners;
        $partners->num_socio = $folio;
        $partners->name = $request->name;
        $partners->last_name = $request->last_name;
        $partners->second_lastname = $request->second_lastname;
        $partners->email = $request->email;
        $partners->age = $request->age;
        $partners->phone = $request->phone;
        $partners->status = 1;
        $partners->phone_emergency = $request->phone_emergency;
        if ($request->certificate != null) {
            //$partners->certification = PartnersController::saveCertificate($request->certificate, $rand);
            $imageCer = base64_encode(file_get_contents($request->file('certificate')));
            $partners->cer = $imageCer;
        }
        if ($request['image-tag'] != null) {
            //$partners->photo = PartnersController::savePhoto($request['image-tag'], $rand);
            $photo = str_replace('data:image/jpeg;base64,', '', $request['image-tag']);
            $partners->foto = $photo;
            //$partners->foto = str_replace('data:image/png;base64,', '', $request['image-tag']);
        }
        if ($request->image != null) {
            //$partners->photo = PartnersController::saveImage($request->image, $rand);
            $image = base64_encode(file_get_contents($request->file('image')));
            $partners->foto = $image;
        }
        if ($request->signData != null) {
            //$partners->sign = PartnersController::saveSign($request->signData, $rand);
            $partners->firma = $request->signData;
        }
        $partners->date = Carbon::now();
        $partners->save();

        $partners_business = new Businesses_partners;
        $partners_business->businesses_id = $request->business_id;
        $partners_business->partners_id = $partners->id;
        $partners_business->save();


        $partner_num_socio = $partners->num_socio;
        $partner_name = $partners->name . ' ' . $partners->last_name . ' ' . $partners->second_lastname;
        $partner_sign = $partners->firma;
        //$partner_photo = $partners->foto;

        $answers = $request->get('answers');

        PartnersController::saveFichaTecnica($answers, $partners->id);

        // $partner_num_socio = '8825092022';
        // $partner_name = 'Herman Toala Ballinas';
        // $partner_sign = 'sign25092022.jpeg';

        $pdf = Pdf::loadView('socios.reglamento', compact('partner_num_socio', 'partner_name', 'partner_sign'))->setPaper('a4')->setWarnings(false)->save(public_path('doc/Reglamento.pdf'));

        /* $zip = new \ZipArchive();
        $fileName = 'valParaiso_Docs' . $partner_num_socio . '.zip';
        if ($zip->open(public_path($fileName), \ZipArchive::CREATE) == TRUE) {
            $files = File::files(public_path('doc'));
            foreach ($files as $key => $value) {
                $relativeName = basename($value);
                $zip->addFile($value, $relativeName);
            }
            $zip->close();
        } */

        $this->senEmail($partners->id);
        return redirect()->route('socios.index');

        //return response()->download(public_path($fileName));

        // return redirect()->route('socios.index');
    }


    public function show(Partners $partners)
    {
    }


    public function edit($id)
    {
        $partner = Partners::find($id);
        return view('socios.edit', compact("partner"));
    }


    public function update(PartnerFormRequest $request, $id)
    {
        /* $this->validate($request, [
            'name' => 'required',
            'last_name' => 'required',
            'age' => 'required',
            'phone' => 'required',
            'phone_emergency' => 'required',
            'sign' => 'required'
        ]); */

        $partners = Partners::find($id);
        $partners->name = $request->name;
        $partners->last_name = $request->last_name;
        $partners->second_lastname = $request->second_lastname;
        $partners->email = $request->email;
        $partners->age = $request->age;
        $partners->phone = $request->phone;
        $partners->phone_emergency = $request->phone_emergency;
        if ($request->certificate != null) {
            //$partners->certification = PartnersController::saveCertificate($request->certificate, $rand);
            $imageCer = base64_encode(file_get_contents($request->file('certificate')));
            $partners->cer = $imageCer;
        }
        if ($request['image-tag'] != null) {
            //$partners->photo = PartnersController::savePhoto($request['image-tag'], $rand);
            $photo = str_replace('data:image/jpeg;base64,', '', $request['image-tag']);
            $partners->foto = $photo;
            //$partners->foto = $request['image-tag'];
        }
        if ($request->image != null) {
            //$partners->photo = PartnersController::saveImage($request->image, $rand);
            $image = base64_encode(file_get_contents($request->file('image')));
            $partners->foto = $image;
        }
        if ($request->signData != null) {
            //$partners->sign = PartnersController::saveSign($request->signData, $rand);
            $partners->firma = $request->signData;
        }

        /* if ($request->certificate != null) {
            $partners->certification = PartnersController::saveCertificate($request->file('certificate'), $partners->num_socio);
        }
        if ($request['image-tag'] != null) {
            $partners->photo = PartnersController::savePhoto($request['image-tag'], $partners->num_socio);
        }
        if ($request->image != null) {
            $partners->photo = PartnersController::saveImage($request->file('image'), $partners->num_socio);
        }
        if ($request->signData != null) {
            $partners->sign = PartnersController::saveSign($request->signData, $partners->num_socio);
        } */
        //$partners->date = Carbon::now();
        $partners->save();

        return redirect()->route('socios.index');
    }

    public function destroy(Request $request, $id)
    {
        $partners = Partners::find($id);
        $partners->status = 2;
        $partners->comm = $request->motivo;
        $partners->save();
        /* DB::table('answer_f_tecnicas')->where('partner_id', $partners->id)->delete();
        DB::table('businesses_partners')->where('partners_id', $partners->id)->delete();
        $partners->delete(); */
        return back();
    }

    // public function makeQR(Request $request)
    // {
    //     $qr = QR::generate($request);
    //     SendMessage::message($phone)->attachText($qr);
    // }

    private function saveFichaTecnica($answers, $idPartner)
    {
        $count = 1;
        foreach ($answers as $answer) {
            $resp = new Answer_fTecnica;
            $resp->answer = ($answer != null ? $answer : 'Ninguna');
            $resp->question_id = $count;
            $resp->partner_id = $idPartner;
            $resp->save();

            $count = $count + 1;
        }
    }

    private function saveCertificate($request, $num_socio)
    {
        $filename = 'certificate' . date('dmY_his') . $num_socio . '.' . $request->getClientOriginalExtension();
        Storage::disk('public')->put($filename, $request);

        return $filename;
    }

    private function saveSign($request, $num_socio)
    {
        $sign = str_replace('data:image/png;base64,', '', $request);
        $signData = base64_decode($sign);
        $signName = 'sign' . date('dmY') . $num_socio . '.jpeg';
        $path = public_path() . "\img\\" . $signName;
        file_put_contents($path, $signData);

        return $signName;
    }

    private function savePhoto($request, $num_socio)
    {
        $photo = str_replace('data:image/jpeg;base64,', '', $request);
        $signData = base64_decode($photo);
        $signName = 'sign' . date('dmY') . $num_socio . '.jpeg';
        $path = public_path() . "\img\\" . $photoName;
        file_put_contents($path, $photoData);

        return $photoName;
    }

    private function saveImage($request, $num_socio)
    {
        $filename = 'photo' . date('dmY_his') . $num_socio . '.' . $request->getClientOriginalExtension();
        $path = public_path() . "\img\\" . $filename;
        file_put_contents($path, $request);

        return $filename;
    }

    public function senEmail($id)
    {
        $partner_name = Partners::select('name')->where('id', $id)->get()->pluck('name');
        $partner_name = $partner_name[0];
        $partner_photo = Partners::select('foto')->where('id', $id)->first();

        $message = [
            'name' => $partner_name,
            'foto' => $partner_photo,
        ];

        Mail::send('socios.email', $message, function ($msj) use ($id) {

            $dataPartner = Partners::select('name', 'num_socio', 'email', 'firma')->where('id', $id)->first();
            $partner_name = $dataPartner->name;
            $partner_num_socio = $dataPartner->num_socio;
            $partner_email = $dataPartner->email;
            $partner_sign = $dataPartner->firma;
            /* $partner_name = Partners::select('name')->where('id', $id)->get()->pluck('name');
            $partner_name = $partner_name[0];
            $partner_name = $partner_name[0];
            $partner_num_socio = Partners::select('num_socio')->where('id', $id)->get()->pluck('num_socio');
            $partner_num_socio = $partner_num_socio[0];
            $partner_email = Partners::select('email')->where('id', $id)->get()->pluck('email');
            $partner_email = $partner_email[0];
            $partner_sign = 'sign' . $partner_num_socio . '.jpeg';
            $partner_photo = Partners::select('foto')->where('id', $id)->first(); */

            $fromEmail = $_ENV['MAIL_USERNAME'];

            $rules = Pdf::loadView('socios.reglamento', compact('partner_num_socio', 'partner_name', 'partner_sign'))->setPaper('a4')->setWarnings(false)->save(public_path('doc/Reglamento.pdf'));
            $aviso = Pdf::loadView('socios.aviso');

            $msj->from($fromEmail, "Spa Val Paraiso");
            $msj->to($partner_email);
            $msj->subject("Entrega de Docs Val Paraiso");
            $msj->attachData($rules->output(), 'Reglamento.pdf');
            $msj->attachData($aviso->output(), 'AvisoPrivTermCdnes.pdf');
        });

        return back();
    }

    public function modals($socio)
    {
        print_r($socio);
        $partnerData = Partners::find($socio);
        //dd($partnerData);
        return view('socios.modals', compact("partnerData"));
    }

    public function modalPago($socio)
    {
        $partnerData = Partners::find($socio);
        return view('socios.ficha_pago', compact("partnerData"));
    }

    public function imprimir($id)
    {
        $partnerData = Partners::find($id);
        //dd($partnerData);
        $pdf = Pdf::loadView('socios.entrega', compact('partnerData'))->setPaper([0, 0, 241, 153])->setWarnings(false);
        return $pdf->stream('credencial.pdf');
        /* $rules = Pdf::loadView('socios.reglamento', compact('partner_num_socio', 'partner_name', 'partner_sign'))->setPaper('a4')->setWarnings(false)->save(public_path('doc/Reglamento.pdf'));
        $aviso = Pdf::loadView('socios.aviso');
        return view('socios.entrega', compact('partnerData')); */
    }
}
