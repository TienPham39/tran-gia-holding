<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'excerpt' => $this->faker->sentence(10),
            'content' => $this->faker->paragraph(10),
            'thumbnail' => '/images/news/thiet-ke-nha-vuon-2000m2-32.png',
            'category' => $this->faker->randomElement(['market', 'planning']),
            'author' => 'Admin',
        ];
    }
}
