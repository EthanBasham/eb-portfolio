<?php

use App\Models\Role;
use App\Models\User;

it('can assign a role to a user', function () {
    $user = User::factory()->create();
    $role = Role::factory()->create(['name' => 'Admin']);

    $user->roles()->attach($role);

    expect($user->fresh()->hasRole('Admin'))->toBeTrue();
});

it('reports false for a role the user does not have', function () {
    $user = User::factory()->create();
    Role::factory()->create(['name' => 'Admin']);

    expect($user->hasRole('Admin'))->toBeFalse();
});
