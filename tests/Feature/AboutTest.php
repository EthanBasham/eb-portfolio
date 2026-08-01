<?php

it('displays the about page successfully', function () {
    $response = $this->get(route('about'));

    $response->assertOk();
    $response->assertSeeText('Where I\'m From');
});
