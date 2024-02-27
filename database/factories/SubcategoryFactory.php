<?php

namespace Database\Factories;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class SubcategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
    
        return [
            'name' =>  $this->faker->name,
            'slug' => Str::slug($this->faker->name),
            'category_id' => Category::all()->first()->id ?? Category::factory()->create()->id,
            'color' => 0,
            'size' => 0

        ];
    }
}
