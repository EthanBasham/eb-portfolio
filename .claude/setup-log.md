# Setup Log — eb-portfolio

Running log of important commands (installs, config, scaffolding decisions) executed while building this project with Claude Code. Newest entries at the bottom.

Environment: WSL2, Ubuntu 24.04 (Noble), project at `~/projects/eb-portfolio`.

> **Note:** `php artisan boost:install` (Laravel Boost) resets the contents of `.claude/` when it syncs its skills/guidelines into that directory — it wiped this file the first time. Recreated below from conversation history. If Boost is ever reinstalled/updated, re-check this file survives, or move it outside `.claude/` (e.g. `docs/setup-log.md`) if it happens again.

---

## 2026-08-01 — Environment recon

Checked for existing toolchain — none of PHP, Composer, Node/npm, or PostgreSQL were installed.

```
php -v        # not found
composer -V   # not found
node -v       # not found
npm -v        # not found
psql --version # not found
```

Checked Ubuntu 24.04 apt repo candidate versions:

| Package | apt candidate |
|---|---|
| php8.3 | 8.3.6-0ubuntu0.24.04.10 |
| nodejs | 18.19.1+dfsg-6ubuntu5 |
| postgresql | 16+257build1.1 |

Decision: PHP 8.3 from Ubuntu repos satisfies the "PHP 8.3+" requirement, no PPA needed. Node 18.19 from apt is behind current LTS — used `nvm` instead (user-local, not NodeSource). PostgreSQL 16 from apt is fine for local dev.

DB note: Local Postgres for dev; production will point at an AWS-hosted Postgres (RDS or similar) provisioned later — `.env.example` documents both.

## 2026-08-01 — Toolchain install

```bash
# PHP 8.3 + extensions, PostgreSQL server
sudo apt install -y php8.3 php8.3-common php8.3-cli php8.3-mbstring php8.3-xml \
  php8.3-curl php8.3-pgsql php8.3-bcmath php8.3-zip php8.3-gd php8.3-intl unzip \
  postgresql postgresql-contrib

# php8.3 metapackage pulled in libapache2-mod-php8.3 and enabled Apache — not needed
# (using `php artisan serve` + Vite instead), so disabled it:
sudo systemctl disable --now apache2

# Composer — official installer script with signature verification
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
# verified sha384 signature against https://composer.github.io/installer.sig
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
# -> Composer 2.10.2

# nvm v0.40.6 (latest release at install time)
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.6/install.sh | bash
nvm install --lts && nvm alias default 'lts/*'
# -> Node v24.18.1, npm 11.16.0
# NOTE: nvm only loads in interactive shells via ~/.bashrc. Non-interactive
# scripts must explicitly `source ~/.nvm/nvm.sh` first, or `node`/`npm` won't
# be found on PATH.

# PostgreSQL 16 — enable + start service
sudo systemctl enable --now postgresql
# cluster: 16 main, port 5432, online

# Laravel installer (global, via Composer)
composer global require laravel/installer
# -> laravel/installer v5.31.0, pulled in illuminate/support v13.23.0
#    confirms Laravel 13.x is current stable, matching the requested version

# Persisted Composer global bin dir on PATH in ~/.bashrc
echo 'export PATH="$HOME/.config/composer/vendor/bin:$PATH"' >> ~/.bashrc
```

Versions confirmed:
- PHP 8.3.6
- Composer 2.10.2
- Node v24.18.1 (LTS), npm 11.16.0
- PostgreSQL 16
- Laravel installer 5.31.0 → Laravel framework 13.x

## 2026-08-01 — Project scaffold

Laravel 13's installer no longer bundles Breeze — starter kits (None/React/Vue/Livewire/Svelte/WorkOS) are now built into `laravel new` itself. Chose the **None** (blank Blade) kit since the brief calls for Blade-only, no SPA framework. Confirmed empirically: the blank kit ships with **zero** auth scaffolding (no `routes/auth.php`, no auth views) — so Breeze is still required separately to get login/register, matching the original request.

```bash
export PATH="$HOME/.config/composer/vendor/bin:$PATH"
cd ~/projects
laravel new eb-portfolio --database=pgsql --pest --npm --git --branch=main --no-boost --force --no-interaction
# --force needed because ~/projects/eb-portfolio already existed (contained this .claude/ dir)
# -> Laravel framework ^13.8, Pest ^4.7, PostgreSQL configured in .env, git repo initialized on `main`

cd ~/projects/eb-portfolio
composer require laravel/breeze --dev
php artisan breeze:install blade --pest --no-interaction
# -> Blade auth stack: login/register/forgot-password/reset-password/verify-email/
#    confirm-password/profile views, routes/auth.php, ProfileController, Alpine.js +
#    Tailwind wired into resources/ (Alpine + Breeze's default Tailwind config will be
#    replaced per the requested custom Tailwind theme + jQuery-only interactivity)

# npm install had to be re-run manually — Breeze's own npm install step failed silently
# during breeze:install because nvm/npm weren't on PATH in that non-interactive shell:
export NVM_DIR="$HOME/.nvm"; . "$NVM_DIR/nvm.sh"
npm install
```

User asked to add **Laravel Boost** (an AI-coding-assist package providing an MCP server,
Laravel/Pest/Tailwind guidelines, and skills for AI agents) after the initial scaffold
had already started without it:

```bash
composer require laravel/boost --dev
php artisan boost:install --guidelines --skills --mcp --no-interaction
# -> auto-detected Claude Code, installed:
#    - 8 guideline docs merged into CLAUDE.md (boost, deployments, foundation,
#      laravel/core, pest/core, php, pint/core, tests)
#    - 3 skills into .claude/skills/ (laravel-best-practices, pest-testing,
#      tailwindcss-development)
#    - MCP server registered in .mcp.json for Claude Code
# CAUTION: this step reset .claude/ and deleted this log file the first time —
# see note at top of this document.
```

Decision: keeping **Alpine.js** (installed by Breeze's blade stack) alongside jQuery, per
user request — it's not an SPA framework, just a small declarative interactivity library,
so it doesn't violate the "no SPA framework" constraint.

## 2026-08-01 — Local database + baseline verification

```bash
# Generated a random dev password, created a dedicated Postgres role + database
sudo -u postgres psql -c "CREATE ROLE eb_portfolio WITH LOGIN PASSWORD '<generated>' CREATEDB;"
sudo -u postgres createdb -O eb_portfolio eb_portfolio

# Confirmed pg_hba.conf already allows scram-sha-256 password auth over TCP
# (127.0.0.1/::1) — no config changes needed, only `local` (unix socket) uses peer auth.

# Updated .env: DB_USERNAME=eb_portfolio, DB_PASSWORD=<generated>
php artisan migrate
# -> users, cache, jobs tables created successfully

# Baseline verification
php artisan serve --port=8000   # -> HTTP 200 on /
npm run build                    # -> vite build succeeded, 803ms
```

Baseline confirmed runnable end-to-end before layering in Tailwind/SASS/jQuery customization.

## 2026-08-01 — Tailwind v4, SASS, jQuery wired into Vite

Discovered Breeze's blade stack actually installs **Tailwind v3.4.19** (classic
`postcss.config.js` + `tailwind.config.js` content-scanning), even though
`@tailwindcss/vite@4.3.3` was present unused in `node_modules` as a transitive dep.
Since the brief asked for latest-stable versions, upgraded to Tailwind **v4** properly.

User explicitly said: no `@config` compatibility bridge — do it the v4 way. So:
- Deleted `tailwind.config.js` and `postcss.config.js` entirely.
- `vite.config.js` now uses `@tailwindcss/vite`'s `tailwindcss()` plugin directly
  (no PostCSS pipeline needed).
- `resources/css/app.css`: `@import 'tailwindcss'; @plugin '@tailwindcss/forms';` +
  a `@theme { ... }` block for the placeholder brand colors/font (Tailwind v4's
  CSS-first token system — these become utilities automatically, e.g. `bg-brand-600`).
- Added `@source '../../vendor/laravel/framework/.../Pagination/resources/views/*.blade.php';`
  — v4 auto-detects template files but skips gitignored paths (vendor/ is gitignored),
  so Laravel's pagination views need an explicit `@source` or their classes get purged.
- User also asked to keep Alpine.js (already installed by Breeze) — it's not an SPA
  framework, so it stays alongside jQuery rather than being removed.

```bash
npm uninstall tailwindcss postcss autoprefixer
npm install -D tailwindcss@4.3.3 sass@1.94.2 jquery@3.7.1
```

`resources/sass/` partial structure added: `_variables.scss`, `_mixins.scss`, `_base.scss`,
`_components.scss`, all imported via `app.scss` (Sass `@use`, not `@import`). Registered
`resources/sass/app.scss` as a third Vite entrypoint (alongside `app.css` and `app.js`) in
both `vite.config.js` and the `@vite([...])` calls in `layouts/app.blade.php` /
`layouts/guest.blade.php`.

`resources/js/app.js`: imports jQuery, exposes it as `window.jQuery`/`window.$`, keeps
Alpine.js init, and adds a working nav-toggle example (jQuery toggles `.is-open` on
`#nav-menu`, driven by the `.nav-toggle`/`.nav-menu` SASS component classes) to prove the
whole pipeline — Blade markup, SASS component styling, jQuery behavior — works together.

`npm run build` verified clean: separate CSS bundles for Tailwind and the SASS partials,
one JS bundle containing jQuery + Alpine.

**Pinned exact versions** (no `^`/`~` ranges) in `composer.json` and `package.json` per the
brief, using the actually-resolved versions:

| composer.json | version | | package.json | version |
|---|---|---|---|---|
| laravel/framework | 13.23.0 | | tailwindcss | 4.3.3 |
| laravel/tinker | 3.0.2 | | @tailwindcss/vite | 4.3.3 |
| laravel/breeze (dev) | 2.4.2 | | @tailwindcss/forms | 0.5.11 |
| laravel/boost (dev) | 2.4.13 | | alpinejs | 3.15.12 |
| laravel/pint (dev) | 1.30.2 | | jquery | 3.7.1 |
| pestphp/pest (dev) | 4.7.7 | | sass | 1.94.2 |
| | | | vite | 8.2.0 |
| | | | laravel-vite-plugin | 3.1.3 |

`php` platform constraint kept as `8.3.*` (wildcard patch) rather than an exact patch
pin — an exact patch pin would break `composer install` on any other 8.3.x patch version,
which isn't the intent of "pin exact versions" for a language runtime constraint.

Ran `composer update --lock` (refreshes the lock file's content-hash without changing
resolved packages) and `npm install` afterward so `composer.lock`/`package-lock.json`
stay consistent with the newly-pinned manifests. `composer validate` passes with only the
expected "exact version constraints should be avoided" advisory warnings, which are
intentional per the brief.

Also fixed a stale line in `CLAUDE.md` (Boost's auto-generated guidelines file) that still
said `tailwindcss v3` after the v4 upgrade.

## 2026-08-01 — DB schema, layout, routes, home page

**Migration/model plan:** the brief's core initial-scaffold feature is "just a solid
homepage," but this is also "the central hub for all of my portfolio projects" — so built
one real model for that: `projects` (title, unique+indexed slug, summary, nullable
description/url/repo_url/image_path, indexed `is_featured` bool, `sort_order`,
indexed+composite `published_at`), with a nullable `user_id` FK (`nullOnDelete`) attributing
projects to the owning user. Resume/cover-letter/informational content stays static Blade
for now — no DB — since making it editable is explicitly a later phase once the
auth-gated content editor exists.

```bash
php artisan make:model Project -mf --no-interaction
php artisan make:seeder ProjectSeeder --no-interaction
php artisan make:controller HomeController --no-interaction
php artisan make:controller ProjectController --model=Project --no-interaction
```

Noticed Laravel 13's `User` model uses PHP attributes (`#[Fillable([...])]`,
`#[Hidden([...])]`) instead of the classic `protected $fillable` array — matched that
convention on `Project.php` for consistency (per Boost's own guideline to follow sibling
file conventions).

`make:controller --model=Project` (without `--resource`) still generated all 7 REST stub
methods with empty bodies — trimmed `ProjectController` down to just `index()`/`show()`
since create/store/edit/update/destroy aren't in scope yet (no content-editing UI exists
until the future CMS-lite phase) and empty stub methods would violate the
no-half-finished-implementations rule.

**Layout:** Breeze's `layouts/app.blade.php` already existed as the authenticated
dashboard shell (via the `<x-app-layout>` component → `App\View\Components\AppLayout`),
included `layouts/navigation.blade.php` (Alpine-driven authenticated navbar). Repurposed
`layouts/app.blade.php` into the one shared site-wide layout the brief asked for: new
`resources/views/partials/header.blade.php` (auth-aware nav — Login/Register when guest,
Dashboard/Profile/Log Out when authenticated) and `partials/footer.blade.php`, both
`@include`d in `layouts/app.blade.php`, preserving the existing `$header`/`$slot` slot
contract so Breeze's dashboard/profile pages kept working unmodified. Left
`layouts/navigation.blade.php` and its component primitives (`x-dropdown`, `x-nav-link`,
etc.) in place unused rather than deleting, since `x-application-logo` is still used by
`layouts/guest.blade.php` (the auth pages) — didn't want to touch shared Breeze
primitives.

The header's mobile nav toggle is the *real* implementation of the jQuery example from
task #5 (not a throwaway demo) — `#nav-menu`/`.nav-menu` collapse via the `_components.scss`
rules, toggled by the jQuery handler in `resources/js/app.js`, fully visible above the `md`
breakpoint via CSS media query regardless of JS state (progressive enhancement — the nav
works with JS disabled, just always expanded).

**Routes/views added:**
- `GET /` → `HomeController@index` (name `home`) — hero + featured projects grid, pulls
  from `Project::published()->where('is_featured', true)->ordered()->get()`.
- `GET /projects` → `ProjectController@index` (name `projects.index`) — paginated listing.
- `GET /projects/{project}` → `ProjectController@show` (name `projects.show`) — route-model
  bound by `slug` (`Project::getRouteKeyName()`), 404s on unpublished/future-dated projects.

Deleted `resources/views/welcome.blade.php` (Laravel's default splash page) since the `/`
route no longer renders it and nothing else referenced it — confirmed via grep before
deleting.

Set `APP_NAME="EB Portfolio"` in `.env`/`.env.example` (was still the Laravel default,
which made the homepage hero read "Hi, I'm Laravel.") — placeholder, personalize as
needed.

Verified end-to-end: `npm run build` clean, then booted `php artisan serve` and curled
`/`, `/projects`, `/projects/{slug}`, `/login` (all 200) and `/dashboard` (302 redirect to
login, confirming route protection works before any auth session exists).

## 2026-08-01 — Tests, Pint, README, final verification

Test config uses Laravel's default sqlite in-memory setup (`phpunit.xml`:
`DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`) — standard Laravel/Pest convention for
fast, isolated test runs, independent of the app's real Postgres driver. The `php-sqlite3`
extension wasn't installed, so tests failed with "could not find driver":

```bash
sudo apt install -y php8.3-sqlite3
```

Added two new Pest feature test files (the brief asked for "a route and a model"):
- `tests/Feature/HomeTest.php` — homepage renders, and only shows published+featured
  projects (not drafts or unfeatured ones).
- `tests/Feature/ProjectTest.php` — `Project::published()` scope excludes drafts/future
  dates, slug route-model binding resolves correctly, unpublished projects 404.

Full suite: `php artisan test --compact` → 30 passed, 71 assertions.

Ran `vendor/bin/pint --format agent` (per Boost's guideline to run Pint after any PHP
changes) — fixed import ordering in `app/Models/Project.php`. `vendor/bin/pint --test`
now passes clean. No custom `pint.json` added — the default `laravel` preset is
sufficient; `.editorconfig` and `.gitignore` already existed from `laravel new`
(Laravel's own defaults, matching the brief's ask).

Rewrote `README.md` (was the generic Laravel skeleton readme) with: tech stack + exact
versions, prerequisites, setup/run/test/format commands, a Laravel-13-vs-5.8 structural
diff (no more `Http/Kernel.php`/`Console/Kernel.php`/`Exceptions/Handler.php` — consolidated
into `bootstrap/app.php`; PHP attributes instead of `protected $fillable`; `casts()` method
instead of `protected $casts`; Vite instead of Mix), and a configuration map (which file
governs which piece of the stack, and the request-flow example for the homepage).

Discovered `laravel new --branch=main` didn't actually set the branch name — repo was on
`master` with zero commits. Renamed to `main` (`git branch -m master main`) since it was
an empty/unborn branch — no history to lose. No commit created (per instructions: only
commit when explicitly asked).

Final verification pass: `php artisan migrate:fresh --seed`, `npm run build`, and
`composer validate` all clean (the only validate warnings are the expected "exact version
constraints" advisories, which are intentional here).

## 2026-08-01 — Ensure PostgreSQL is running before `composer run dev`

Postgres is already `systemctl enable`d so it should auto-start when WSL's systemd boots,
but that's not a hard guarantee. Added a belt-and-suspenders check tied to the dev
workflow itself.

Checked first (read-only) before designing this: `pg_isready`/`service`/`systemctl` are
all installed, and this user already has passwordless sudo system-wide (`sudo -l` →
`(ALL) NOPASSWD: ALL`, likely a default from the WSL image's cloud-init provisioning) — so
`sudo service postgresql start` never blocks on a password prompt. No sudoers changes
needed.

Added `scripts/ensure-postgres.sh` (executable): checks `pg_isready` first and skips
`sudo` entirely when Postgres is already up (the common case — avoids unnecessary sudo
overhead on every single `composer run dev`); only runs `sudo service postgresql start`
when it's actually down, then polls `pg_isready` for up to 5s and fails loudly
(non-zero exit, clear stderr message) if it still isn't reachable, rather than silently
continuing into `php artisan serve` and failing later with a confusing DB error.

Wired into `composer.json` as a new `ensure-postgres` script, prepended as the first step
of both `dev` and `setup` (the latter also runs migrations, so it has the same latent
need) — using `"@ensure-postgres"` as the first array entry, not Composer's
`pre-<name>-cmd` event-hook convention, since sequential array composition is the more
certain/unambiguous mechanism. Ran `composer update --lock` afterward to refresh
`composer.lock`'s content-hash to match the changed `composer.json`.

Verified: fast path (already running) skips sudo; stopped Postgres via
`sudo systemctl stop postgresql` and confirmed `composer run ensure-postgres` detects it
and starts it back up; full `composer run dev` chain boots cleanly with the new step
running first.

## 2026-08-01 — /resume page

Read the supplied PDF (`public/docs/Resume - Ethan Basham.pdf`) directly via Claude's PDF
support, then brainstormed the approach with the user before building anything (plan mode).
Decisions:

- Dedicated `/resume` HTML page mirroring the PDF's content, not a homepage section or
  PDF-only link — better for SEO/screen readers/browsing friction. Nav "Resume" link goes
  to the page, which has a "Download PDF" button near the top (one nav item, not two).
- **Privacy**: explicitly excluded phone number and email from the public, search-indexed
  page — user's call, since once a search engine crawls/caches a phone number it's hard to
  scrub. Location (Murfreesboro, TN) stays. Guarded by a Pest test
  (`tests/Feature/ResumeTest.php`) asserting neither appears in the response body, so a
  future edit can't silently reintroduce them.
- Renamed the PDF from `Resume - Ethan Basham.pdf` to `resume-ethan-basham.pdf` (spaces in
  a public URL are asking for encoding bugs; matches the project's existing kebab-case
  asset naming like `laravel-code-hero-light.png`).
- `/resume` route is a closure in `routes/web.php`, matching the existing `/dashboard`
  pattern (no controller — no model/logic behind a static content page, would be an empty
  wrapper).
- Noticed `resources/views/projects/show.blade.php` uses a `prose` class, but
  `@tailwindcss/typography` was never installed, so that class has silently done nothing
  since it was written. Didn't fix it (out of scope) but avoided repeating it on the new
  page — used explicit utility classes instead, matching what's actually functional.
- Explicitly deferred: the homepage's "Get in touch" button still points at a leftover
  placeholder email (`hello@example.com`) from scaffolding, not the real one. Flagged to
  the user; they want it left alone for now rather than wired up, given the same privacy
  reasoning as above.

Also found and cleaned up a stale `public/hot` file left over from an earlier
`composer run dev` test in this session — its presence makes Laravel's `@vite()` directive
try to load assets from a Vite dev server on :5173 instead of the built `public/build`
files, silently breaking styling/JS on every page until removed or `npm run dev` is
actually running.
