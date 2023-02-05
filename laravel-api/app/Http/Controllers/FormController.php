<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Models\Form;
use App\Models\FcaCreds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class FormController extends Controller
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
     * @param  \App\Http\Requests\StoreFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFormRequest $request)
    {
        // VALIDATE REQUEST
        $validator = Validator::make($request->all(), [
            "frn" => "required"
        ]);

        if ($validator->fails()) {
            return response(
                $validator->errors(),
                400
            );
        }

        // GET FCA CREDENTIALS
        $fcaCreds = FcaCreds::first();

        // CHECK CACHE FOR FRN
        $result = Cache::get("frn_exists_{$request->frn}");    
        if ($result !== null) return redirect('/')
            ->with('status', $result->status)
            ->with('message', $result->message);

        // MAKE FCA API CALL
        $response = Http::withHeaders([
            'X-Auth-Email' => $fcaCreds->email,
            'X-Auth-Key' => $fcaCreds->key,
            'Content-Type' => 'application/json'
        ])->get("https://register.fca.org.uk/services/V0.1/Firm/{$request->frn}")->object();

        // CHECK STATUS
        $result = response();
        switch($response->Status) {
            case 'FSR-API-02-01-11':
                $result = response(
                    [
                        'status' => 'fail',
                        'message' => 'Firm not found',
                        'response' => $response
                    ], 200
                );
                break;
            case 'FSR-API-02-01-00':
                $result = response(
                    [
                        'status' => 'success',
                        'message' => 'Firm found',
                        'response' => $response
                    ], 200
                );
                break;
            default:
                $result = response(
                    [
                        'status' => 'fail',
                        'message' => 'Unknown error occurred',
                        'response' => $response
                    ], 200
                );
                break;
        }

        // CACHE RESPONSE
        Cache::put("frn_exists_{$request->frn}", $result, 60);

        return redirect('/')
            ->with('status', $result->content('status'))
            ->with('message', $result->content('message'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFormRequest  $request
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFormRequest $request, Form $form)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        //
    }
}
