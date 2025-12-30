<?php

namespace Database\Factories;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Price>
 */
class PriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Price::class;
    public function definition(): array
    {
         $startDate = $this->faker->date('Y-m-d'); 
          $endDate = $this->faker->dateTimeBetween($startDate, '+1 year')->format('Y-m-d');
        return [
        'product_id' => Product::factory(),
        'price' =>  $this->faker->randomFloat(2, 1, 1000),
        "discount" => $this->faker->randomFloat(2, 1, 10),
        "start_date"=>$startDate,
        "end_date" => $endDate,
        ];
    }
}
