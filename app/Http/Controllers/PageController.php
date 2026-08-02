<?php

namespace App\Http\Controllers;

use App\Enums\PageFormat;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Stevebauman\Purify\Facades\Purify;

class PageController extends Controller
{
    public function edit(Page $page): View
    {
        return view('pages.edit', [
            'page' => $page,
        ]);
    }

    public function update(UpdatePageRequest $request, Page $page): RedirectResponse
    {
        $format = PageFormat::from($request->validated('format'));

        // Markdown content is stored as-is (safety is enforced at render
        // time by Page::renderedContent()); wysiwyg HTML is sanitized here,
        // before storage; raw HTML is trusted as-is, same as editing a
        // Blade file directly — only the Admin-gated route can reach it.
        $content = $format === PageFormat::Wysiwyg
            ? Purify::clean($request->validated('content'))
            : $request->validated('content');

        $page->update([
            'title' => $request->validated('title'),
            'format' => $format,
            'content' => $content,
        ]);

        // Seeded page slugs are chosen to match their public route names
        // (about/resume), so this holds for every page currently in the system.
        return redirect()->route($page->slug)->with('status', 'Page updated.');
    }
}
