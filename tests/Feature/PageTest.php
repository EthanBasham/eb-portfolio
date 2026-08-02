<?php

use App\Enums\PageFormat;
use App\Models\Page;
use App\Models\Role;
use App\Models\User;

function makeAdmin(): User
{
    $user = User::factory()->create();
    $role = Role::query()->firstOrCreate(['name' => 'Admin']);

    $user->roles()->attach($role);

    return $user;
}

it('renders the about and resume pages for guests', function () {
    $about = Page::factory()->create(['slug' => 'about']);
    $resume = Page::factory()->rawFormat()->create(['slug' => 'resume']);

    $this->get(route('about'))->assertOk()->assertSeeText($about->title);
    $this->get(route('resume'))->assertOk();
});

it('does not show an edit link to guests', function () {
    Page::factory()->create(['slug' => 'about']);

    $this->get(route('about'))->assertDontSee('/pages/about/edit');
});

it('redirects guests away from the edit form', function () {
    $page = Page::factory()->create(['slug' => 'about']);

    $this->get(route('pages.edit', $page))->assertRedirect(route('login'));
});

it('blocks authenticated non-admin users from editing pages', function () {
    $page = Page::factory()->create(['slug' => 'about']);
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('pages.edit', $page))->assertForbidden();
});

it('lets an admin view and update a wysiwyg page, sanitizing the content', function () {
    $admin = makeAdmin();
    $page = Page::factory()->create(['slug' => 'about', 'format' => 'wysiwyg']);

    $this->actingAs($admin)->get(route('pages.edit', $page))->assertOk();

    $response = $this->actingAs($admin)->put(route('pages.update', $page), [
        'title' => 'Updated Title',
        'format' => 'wysiwyg',
        'content' => '<p>Hello</p><script>alert(1)</script>',
    ]);

    $response->assertRedirect(route('about'));

    $page->refresh();
    expect($page->title)->toBe('Updated Title');
    expect($page->content)->toContain('<p>Hello</p>');
    expect($page->content)->not->toContain('<script>');
});

it('lets an admin update a raw page without sanitizing the content', function () {
    $admin = makeAdmin();
    $page = Page::factory()->rawFormat()->create(['slug' => 'resume', 'format' => 'raw']);

    $raw = '<div class="mx-auto max-w-3xl"><h2 class="text-2xl font-bold">Custom</h2></div>';

    $response = $this->actingAs($admin)->put(route('pages.update', $page), [
        'title' => 'Updated Resume',
        'format' => 'raw',
        'content' => $raw,
    ]);

    $response->assertRedirect(route('resume'));

    $page->refresh();
    expect($page->content)->toBe($raw);
});

it('renders markdown content as HTML on the public page', function () {
    $page = Page::factory()->create([
        'slug' => 'about',
        'format' => 'md',
        'content' => "# Heading\n\nSome **bold** text.",
    ]);

    $response = $this->get(route('about'));

    $response->assertOk();
    $response->assertSee('<h1>Heading</h1>', false);
    $response->assertSee('<strong>bold</strong>', false);
});

it('escapes raw HTML typed into markdown source instead of executing it', function () {
    $page = Page::factory()->create([
        'slug' => 'about',
        'format' => 'md',
        'content' => "Some text.\n\n<script>alert(1)</script>",
    ]);

    $response = $this->get(route('about'));

    $response->assertOk();
    $response->assertDontSee('<script>', false);
});

it('lets an admin switch a page from markdown to wysiwyg', function () {
    $admin = makeAdmin();
    $page = Page::factory()->create(['slug' => 'about', 'format' => 'md', 'content' => '# Old']);

    $response = $this->actingAs($admin)->put(route('pages.update', $page), [
        'title' => 'About',
        'format' => 'wysiwyg',
        'content' => '<p>New rich content</p>',
    ]);

    $response->assertRedirect(route('about'));

    $page->refresh();
    expect($page->format)->toBe(PageFormat::Wysiwyg);
    expect($page->content)->toBe('<p>New rich content</p>');
});

it('rejects an update with an invalid format value', function () {
    $admin = makeAdmin();
    $page = Page::factory()->create(['slug' => 'about']);

    $response = $this->actingAs($admin)->put(route('pages.update', $page), [
        'title' => 'About',
        'format' => 'not-a-real-format',
        'content' => '<p>Hi</p>',
    ]);

    $response->assertSessionHasErrors('format');
});
