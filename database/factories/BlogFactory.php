<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'thumbnail' => 'thumbnails/' . $this->faker->image('public/storage/thumbnails', 640, 480, null, false),
            'main_image' => 'main_image/' . $this->faker->image('public/storage/main_images', 800, 600, null, false),
        ];
    }
}
