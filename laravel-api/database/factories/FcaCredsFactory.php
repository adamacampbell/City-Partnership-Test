<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FcaCreds>
 */
class FcaCredsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'email' => env('FCA_AUTH_EMAIL', null),
            'key' => env('FCA_AUTH_KEY', null)
        ];
    }
}
