<?php

namespace Database\Factories;

use App\Models\ProductTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductTraslationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductTranslation::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => '',
            "description" => $this->faker->sentence(),
            "long_description" => $this->faker->paragraph(),
            "url" => '',
            "language" => '',
            "product_id" => '',
        ];
    }
}
