<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'coin_name' => Str::upper($this->faker->word()),
            'coin_logo_path' => null,
        ];
    }

}
