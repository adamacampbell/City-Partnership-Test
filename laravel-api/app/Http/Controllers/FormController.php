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
        if (!$fcaCreds) {
            return redirect('/')
                ->with('status', 'danger')
                ->with('message', 'Must enter FCA API Credentials');
        }

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

        if (!$response) {
            return redirect('/')
                ->with('status', 'danger')
                ->with('message', 'Must enter valid FCA API Credentials');
        }

        // CHECK STATUS
        $status = null;

        switch($response->Status) {
            case 'FSR-API-02-01-11':
                $status = 'warning';
                $message = "Firm {$request->frn} not found";
                break;
            case 'FSR-API-02-01-00':
                $status = 'success';
                $message = "Firm {$request->frn} found - {$response->Data[0]->{'Organisation Name'}}";
                break;
            default:
                $status = 'danger';
                $message = 'Unknown error occurred';
                break;
        }

        // CACHE RESPONSE
        Cache::put("frn_exists_{$request->frn}", $result, 60);

        return redirect('/')
            ->with('status', $status)
            ->with('message', $message)
            ->with('response', $response);
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
