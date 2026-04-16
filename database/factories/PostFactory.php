<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
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
            'category_id' => Category::factory(),
            'title' => fake()->sentence(),
            'slug' => fake()->unique()->slug(),
            'body' => fake()->paragraphs(3, true),
            'image' => fake()->imageUrl(),
            'status' => 'public',
        ];
    }
}
