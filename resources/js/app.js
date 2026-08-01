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
