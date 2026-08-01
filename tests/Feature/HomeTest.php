<?php

use App\Models\Project;

it('displays the homepage successfully', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
});

it('shows only published, featured projects on the homepage', function () {
    $featured = Project::factory()->featured()->create(['published_at' => now()]);
    $unfeatured = Project::factory()->create(['is_featured' => false, 'published_at' => now()]);
    $draft = Project::factory()->featured()->draft()->create();

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSeeText($featured->title);
    $response->assertDontSeeText($unfeatured->title);
    $response->assertDontSeeText($draft->title);
});
