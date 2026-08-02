<?php

use Database\Seeders\PageSeeder;

it('displays the resume page successfully', function () {
    $this->seed(PageSeeder::class);

    $response = $this->get(route('resume'));

    $response->assertOk();
    $response->assertSeeText('Ethan Basham');
});

it('does not expose a phone number or personal email on the public page', function () {
    $this->seed(PageSeeder::class);

    $response = $this->get(route('resume'));

    $response->assertOk();
    $response->assertDontSeeText('931');
    $response->assertDontSee('ethan_basham@outlook.com');
});
