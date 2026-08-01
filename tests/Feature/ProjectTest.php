<?php

use App\Models\Project;

it('only includes published projects in the published scope', function () {
    $published = Project::factory()->create(['published_at' => now()->subDay()]);
    Project::factory()->draft()->create();
    Project::factory()->create(['published_at' => now()->addWeek()]);

    $results = Project::published()->get();

    expect($results)->toHaveCount(1);
    expect($results->first()->is($published))->toBeTrue();
});

it('resolves route model binding by slug', function () {
    $project = Project::factory()->create(['published_at' => now()]);

    $response = $this->get(route('projects.show', $project));

    $response->assertOk();
    $response->assertSeeText($project->title);
});

it('returns 404 for a project that is not yet published', function () {
    $project = Project::factory()->draft()->create();

    $response = $this->get(route('projects.show', $project));

    $response->assertNotFound();
});
