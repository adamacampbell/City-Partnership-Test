<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFcaCredsRequest;
use App\Http\Requests\UpdateFcaCredsRequest;
use App\Models\FcaCreds;
use App\Http\Resources\FcaCredsResource;
use Illuminate\Support\Facades\Validator;

class FcaCredsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FcaCredsResource::collection(FcaCreds::all());
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
        $fcaCreds = FcaCreds::create([
            'email' => $request->email,
            'key' => $request->key
        ]);
        // ENFORCE ONCE CRED ENTRY
        FcaCreds::whereNot('id', $fcaCreds->id)->delete();
        return new FcaCredsResource($fcaCreds);
    }

    /**
     * Store a newly created resource in storage from Web UI.
     *
     * @param  \App\Http\Requests\StoreFcaCredsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function storeWeb(StoreFcaCredsRequest $request)
    {
        // VALIDATE REQUEST
        $validator = Validator::make($request->all(), [
            "frn" => "required"
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->with('creds-status', 'danger')
                ->with('creds-message', 'Missing FCA Credentials');
        }

        // CREATE NEW CRED ENTRY
        $fcaCreds = FcaCreds::create([
            'email' => $request->email,
            'key' => $request->key
        ]);

        // ENFORCE ONE CRED ENTRY
        FcaCreds::whereNot('id', $fcaCreds->id)->delete();
        
        // UPDATE UI
        return redirect('/')
            ->with('creds-status', 'success')
            ->with('creds-message', 'Credentials Stored');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FcaCreds  $fcaCreds
     * @return \Illuminate\Http\Response
     */
    public function show(FcaCreds $fcaCreds)
    {
        // JUST RETURN FIRST, WE SHOULD ONLY ALLOW 1 ENTRY
        $creds = FcaCreds::first();
        return new FcaCredsResource($creds);
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
        $fcaCreds->update([
            'email' => $request->email,
            'key' => $request->key
        ]);

        return new FcaCredsResource($fcaCreds);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FcaCreds  $fcaCreds
     * @return \Illuminate\Http\Response
     */
    public function destroy(FcaCreds $fcaCreds)
    {
        $fcaCreds->delete();
        return response(null, 204);
    }
}
