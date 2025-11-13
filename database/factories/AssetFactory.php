<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AssetFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'valor_contabil' => $this->faker->randomFloat(2, 100, 5000),
            'latitude_distribuicao' => $this->faker->latitude(),
            'longitude_distribuicao' => $this->faker->longitude(),
            'status' => 'EM_USO',
        ];
    }
}
