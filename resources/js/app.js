import Alpine from 'alpinejs';
import $ from 'jquery';
import Quill from 'quill';

window.Alpine = Alpine;
window.jQuery = window.$ = $;

Alpine.start();

// Progressive-enhancement example: mobile nav toggle. The markup works with
// no JS (menu is visible by default via Tailwind's md: breakpoint in the
// layout); this just adds the collapsible behaviour below md.
$(function () {
    const $toggle = $('.nav-toggle');
    const $menu = $('#nav-menu');

    $toggle.on('click', function () {
        const expanded = $toggle.attr('aria-expanded') === 'true';

        $toggle.attr('aria-expanded', String(!expanded));
        $menu.toggleClass('is-open');
    });
});

// Subtle parallax drift on the homepage hero background — the image scrolls
// slower than the page instead of being fully pinned (bg-fixed), which read
// as too abrupt. Offset is small and capped so it stays subtle, and it's
// skipped entirely for users who prefer reduced motion.
$(function () {
    const $hero = $('#hero');

    if (!$hero.length || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const parallaxFactor = 0.3;
    const maxOffset = 120;
    let ticking = false;

    const updateHeroParallax = () => {
        const offset = Math.max(-maxOffset, Math.min(maxOffset, window.scrollY * parallaxFactor));
        $hero.css('background-position', `center calc(50% + ${offset}px)`);
        ticking = false;
    };

    $(window).on('scroll', function () {
        if (!ticking) {
            window.requestAnimationFrame(updateHeroParallax);
            ticking = true;
        }
    });
});

// Page-edit form: three content editors (Quill, Markdown textarea, raw HTML
// textarea) share the page, one per format. The format radios show/hide
// whichever one is active; on submit, the active editor's content gets
// copied into the single #content field that's actually sent to the server.
$(function () {
    const $container = $('#editor-container');
    const $radios = $('.format-radio');
    const $field = $('#content');

    if (!$container.length || !$radios.length) {
        return;
    }

    // Quill's default image toolbar button reads a local file and embeds it
    // as a base64 data URI directly, so it works without any upload
    // endpoint — fine for occasional images, not a real media library.
    const quill = new Quill($container[0], {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ header: [2, 3, false] }],
                ['bold', 'italic', 'blockquote', 'code'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['link', 'image'],
                ['clean'],
            ],
        },
    });

    // Match the typography the public page renders with, so the editor
    // looks like the thing it's editing.
    $(quill.root).addClass('prose prose-gray max-w-none');
    quill.clipboard.dangerouslyPasteHTML($('#wysiwyg-initial').val());

    const $editors = $('.format-editor');

    const showActiveEditor = () => {
        const format = $radios.filter(':checked').val();

        $editors.each(function () {
            $(this).toggleClass('hidden', $(this).data('format') !== format);
        });
    };

    $radios.on('change', showActiveEditor);
    showActiveEditor();

    $field.closest('form').on('submit', function () {
        const format = $radios.filter(':checked').val();

        if (format === 'wysiwyg') {
            $field.val(quill.root.innerHTML);
        } else if (format === 'md') {
            $field.val($('#markdown-editor').val());
        } else {
            $field.val($('#raw-editor').val());
        }
    });
});
