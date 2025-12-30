<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'product_id' => $this->faker->numberBetween(1, 1000000000), // BIGINT for product_id
            'category_color_id' => $this->faker->numberBetween(1, 1000000000), // BIGINT for category_color_id
            'category_size_id' => $this->faker->numberBetween(1, 1000000000), // BIGINT for category_size_id
            'stock_quantity' => $this->faker->numberBetween(0, 32767), // SMALLINT range for stock_quantity
            'created_at' => now(), // Timestamp for created_at
            'updated_at' => now(), // Timestamp for updated_at
        ];
    }
}
