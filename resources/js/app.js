import Alpine from 'alpinejs';
import $ from 'jquery';

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
