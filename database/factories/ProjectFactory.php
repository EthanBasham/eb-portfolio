<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = ucfirst(fake()->words(3, true));

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 100000),
            'summary' => fake()->sentence(12),
            'description' => fake()->paragraphs(3, true),
            'url' => fake()->boolean(70) ? fake()->url() : null,
            'repo_url' => fake()->boolean(80) ? 'https://github.com/example/'.Str::slug($title) : null,
            'image_path' => null,
            'is_featured' => fake()->boolean(25),
            'sort_order' => fake()->numberBetween(0, 100),
            'published_at' => fake()->boolean(85) ? fake()->dateTimeBetween('-2 years') : null,
        ];
    }

    /**
     * Indicate that the project is featured on the homepage.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the project has not been published yet.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => null,
        ]);
    }
}
