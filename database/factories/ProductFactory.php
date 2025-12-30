<?php

namespace Database\Factories;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;
    public function definition(): array
    {
         return [
        'product_name' => fake()->word(),
        'description' =>  fake()->word(),
        "total_stock" => fake()->randomNumber(2),
        "type_id"=>Type::factory(),

        ];
    }
}
