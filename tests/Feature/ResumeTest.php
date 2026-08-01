<?php

it('displays the resume page successfully', function () {
    $response = $this->get(route('resume'));

    $response->assertOk();
    $response->assertSeeText('Ethan Basham');
});

it('does not expose a phone number or personal email on the public page', function () {
    $response = $this->get(route('resume'));

    $response->assertOk();
    $response->assertDontSeeText('931');
    $response->assertDontSee('ethan_basham@outlook.com');
});
