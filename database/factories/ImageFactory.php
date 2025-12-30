<?php

namespace Database\Factories;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Image::class;
    public function definition(): array
    {
        return [
        'image_path' => fake()->word(),
        'image_200x200' =>  fake()->word(),
        "image_400x400" => fake()->word(),
        "image_800x800"=>fake()->word(),
        "image_1200x1200"=>fake()->word(),

        ];
    }
}
