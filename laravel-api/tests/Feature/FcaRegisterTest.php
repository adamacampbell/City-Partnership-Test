<?php

namespace Tests\Feature;

use App\Models\FcaCreds;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FcaRegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test a successful FRN Check.
     *
     * @return void
     */
    public function test_frn_should_pass()
    {
        FcaCreds::create([
            'email' => env('FCA_AUTH_EMAIL', null),
            'key' => env('FCA_AUTH_KEY', null)
        ]);

        $response = $this->json(
            'POST',
            '/api/fca-register/check-exists',
            ['frn' => '900706']
        );

        // RESPONSE PASS
        $response->assertStatus(200);

        $content = json_decode($response->content());
        // STATUS SHOULD BE SUCCESS
        $this->assertEquals('success', $content->status);
    }

    /**
     * Test a failing FRN check
     * Fails due to missing FCA API credentials.
     *
     * @return void
     */
    public function test_frn_should_fail_creds_missing()
    {
        $response = $this->json(
            'POST',
            '/api/fca-register/check-exists',
            ['frn' => '900706']
        );

        $response->assertStatus(500);
    }

    /**
     * Test a failing FRN check
     * Fails due to invalid FCA API credentials.
     *
     * @return void
     */
    public function test_frn_should_fail_creds_invalid()
    {
        FcaCreds::create([
            'email' => '-1',
            'key' => '-1'
        ]);

        $response = $this->json(
            'POST',
            '/api/fca-register/check-exists',
            ['frn' => '900706']
        );

        $response->assertStatus(500);
    }

    /**
     * Test a failing FRN check
     * Fails due to invalid FRN number.
     *
     * @return void
     */
    public function test_frn_should_fail_frn_invalid()
    {
        FcaCreds::create([
            'email' => env('FCA_AUTH_EMAIL', null),
            'key' => env('FCA_AUTH_KEY', null)
        ]);

        $response = $this->json(
            'POST',
            '/api/fca-register/check-exists',
            ['frn' => 'DEBUG']
        );

        // RESPONSE SHOULD STILL PASS
        $response->assertStatus(200);

        $content = json_decode($response->content());
        // STATUS SHOULD FAIL
        $this->assertEquals('danger', $content->status);
    }

    /**
     * Test a failing FRN check
     * Fails due to invalid FRN not being found.
     *
     * @return void
     */
    public function test_frn_should_fail_frn_missing()
    {
        FcaCreds::create([
            'email' => env('FCA_AUTH_EMAIL', null),
            'key' => env('FCA_AUTH_KEY', null)
        ]);

        $response = $this->json(
            'POST',
            '/api/fca-register/check-exists',
            ['frn' => '1']
        );

        // RESPONSE SHOULD STILL PASS
        $response->assertStatus(200);

        $content = json_decode($response->content());
        // STATUS SHOULD FAIL
        $this->assertEquals('warning', $content->status);
    }
}
