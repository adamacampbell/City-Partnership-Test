<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFcaRegisterRequest;
use App\Http\Requests\UpdateFcaRegisterRequest;
use App\Models\FcaCreds;
use App\Models\FcaRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class FcaRegisterController extends Controller
{
    public function checkFirmExists(Request $request) {
        // VALIDATE REQUEST
        $validator = Validator::make($request->all(), [
            "frm" => "required"
        ]);

        if ($validator->fails()) {
            return response(
                $validator->errors(),
                400
            );
        }

        // GET FCA CREDENTIALS
        $fcaCreds = FcaCreds::first();

        // MAKE FCA API CALL
        $response = Http::withHeaders([
            'X-Auth-Email' => $fcaCreds->email,
            'X-Auth-Key' => $fcaCreds->key,
            'Content-Type' => 'application/json'
        ])->get("https://register.fca.org.uk/services/V0.1/Firm/{$request->frm}")->object();

        
        // CHECK STATUS
        switch($response->Status) {
            case 'FSR-API-02-01-11':
                return response(
                    [
                        'status' => 'fail',
                        'message' => 'Firm not found',
                        'response' => $response
                    ], 200
                );
                break;
            case 'FSR-API-02-01-00':
                return response(
                    [
                        'status' => 'success',
                        'message' => 'Firm found',
                        'response' => $response
                    ], 200
                );
                break;
            default:
                return response(
                    [
                        'status' => 'fail',
                        'message' => 'Unknown error occurred',
                        'response' => $response
                    ]
                );
                break;
        }
        return $response;
    }

    // TODO: REMOVE DEFAULT CONTROLS?
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
     * @param  \App\Http\Requests\StoreFcaRegisterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFcaRegisterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FcaRegister  $fcaRegister
     * @return \Illuminate\Http\Response
     */
    public function show(FcaRegister $fcaRegister)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FcaRegister  $fcaRegister
     * @return \Illuminate\Http\Response
     */
    public function edit(FcaRegister $fcaRegister)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFcaRegisterRequest  $request
     * @param  \App\Models\FcaRegister  $fcaRegister
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFcaRegisterRequest $request, FcaRegister $fcaRegister)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FcaRegister  $fcaRegister
     * @return \Illuminate\Http\Response
     */
    public function destroy(FcaRegister $fcaRegister)
    {
        //
    }
}
