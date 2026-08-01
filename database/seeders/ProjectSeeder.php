<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $owner = User::first() ?? User::factory()->create();

        $placeholders = [
            [
                'title' => 'eb-portfolio',
                'summary' => 'This site — a Laravel + Tailwind + jQuery portfolio hub.',
                'is_featured' => true,
                'sort_order' => 0,
            ],
            [
                'title' => 'Sample Project One',
                'summary' => 'Placeholder summary for a featured portfolio project.',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Sample Project Two',
                'summary' => 'Placeholder summary for another portfolio project.',
                'is_featured' => false,
                'sort_order' => 2,
            ],
        ];

        foreach ($placeholders as $placeholder) {
            Project::query()->updateOrCreate(
                ['slug' => Str::slug($placeholder['title'])],
                [
                    'user_id' => $owner->id,
                    'title' => $placeholder['title'],
                    'summary' => $placeholder['summary'],
                    'description' => fake()->paragraphs(3, true),
                    'repo_url' => 'https://github.com/example/'.Str::slug($placeholder['title']),
                    'is_featured' => $placeholder['is_featured'],
                    'sort_order' => $placeholder['sort_order'],
                    'published_at' => now(),
                ]
            );
        }

        Project::factory()
            ->count(5)
            ->create(['user_id' => $owner->id]);
    }
}
