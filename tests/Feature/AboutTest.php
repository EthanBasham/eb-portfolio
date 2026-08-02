<?php

use Database\Seeders\PageSeeder;

it('displays the about page successfully', function () {
    $this->seed(PageSeeder::class);

    $response = $this->get(route('about'));

    $response->assertOk();
    $response->assertSeeText('Where I\'m From');
});
