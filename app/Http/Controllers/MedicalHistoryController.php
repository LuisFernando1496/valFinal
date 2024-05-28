<?php

namespace App\Http\Controllers;

use App\Models\MedicalHistory;
use App\Http\Requests\StoreMedicalHistoryRequest;
use App\Http\Requests\UpdateMedicalHistoryRequest;

class MedicalHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMedicalHistoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMedicalHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MedicalHistory  $medicalHistory
     * @return \Illuminate\Http\Response
     */
    public function show(MedicalHistory $medicalHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MedicalHistory  $medicalHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(MedicalHistory $medicalHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMedicalHistoryRequest  $request
     * @param  \App\Models\MedicalHistory  $medicalHistory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMedicalHistoryRequest $request, MedicalHistory $medicalHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedicalHistory  $medicalHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalHistory $medicalHistory)
    {
        //
    }
}
