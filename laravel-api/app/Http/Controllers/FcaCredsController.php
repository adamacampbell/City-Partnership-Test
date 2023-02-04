<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFcaCredsRequest;
use App\Http\Requests\UpdateFcaCredsRequest;
use App\Models\FcaCreds;

class FcaCredsController extends Controller
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
     * @param  \App\Http\Requests\StoreFcaCredsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFcaCredsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FcaCreds  $fcaCreds
     * @return \Illuminate\Http\Response
     */
    public function show(FcaCreds $fcaCreds)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FcaCreds  $fcaCreds
     * @return \Illuminate\Http\Response
     */
    public function edit(FcaCreds $fcaCreds)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFcaCredsRequest  $request
     * @param  \App\Models\FcaCreds  $fcaCreds
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFcaCredsRequest $request, FcaCreds $fcaCreds)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FcaCreds  $fcaCreds
     * @return \Illuminate\Http\Response
     */
    public function destroy(FcaCreds $fcaCreds)
    {
        //
    }
}
