<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);

        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'format' => 'wysiwyg',
            'content' => '<p>'.fake()->paragraph().'</p>',
        ];
    }

    /**
     * Indicate that the page stores raw, unsanitized HTML.
     */
    public function rawFormat(): static
    {
        return $this->state(fn (array $attributes) => [
            'format' => 'raw',
        ]);
    }
}
