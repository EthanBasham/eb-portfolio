<?php

namespace App\Models;

use App\Enums\PageFormat;
use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable(['title', 'content', 'format'])]
class Page extends Model
{
    /** @use HasFactory<PageFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'format' => PageFormat::class,
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isRaw(): bool
    {
        return $this->format === PageFormat::Raw;
    }

    public function isMarkdown(): bool
    {
        return $this->format === PageFormat::Markdown;
    }

    /**
     * The HTML to render for this page. Markdown content is converted on the
     * fly (with raw HTML in the source escaped, not executed); wysiwyg/raw
     * content is already final HTML, stored as-is.
     */
    public function renderedContent(): string
    {
        if (! $this->isMarkdown()) {
            return $this->content;
        }

        return Str::markdown($this->content, [
            'html_input' => 'escape',
            'allow_unsafe_links' => false,
        ]);
    }
}
