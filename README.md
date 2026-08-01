# eb-portfolio

Personal portfolio hub — resume, projects, and (eventually) blog-style content. Built with
Laravel 13, Blade, Tailwind CSS v4, SASS, and jQuery.

## Tech stack

| Layer | Choice | Version |
|---|---|---|
| Language / framework | PHP / Laravel | 8.3 / 13.23.0 |
| Templating | Blade (no Livewire/Inertia/Vue/React) | — |
| Auth | Laravel Breeze (blade stack) | 2.4.2 |
| Utility CSS | Tailwind CSS (CSS-first config, no `tailwind.config.js`) | 4.3.3 |
| Custom styling | SASS (partials in `resources/sass/`) | 1.94.2 |
| Interactivity | jQuery (+ Alpine.js, kept from Breeze) | 3.7.1 / 3.15.12 |
| Bundler | Vite | 8.2.0 |
| Database | PostgreSQL (local dev; AWS-hosted Postgres in production) | 16 |
| Testing | Pest | 4.7.7 |
| Formatting | Laravel Pint | 1.30.2 |
| AI-assist | Laravel Boost (MCP server, guidelines, skills) | 2.4.13 |

All versions are pinned exactly (no `^`/`~` ranges) in `composer.json` and `package.json`.

## Prerequisites

- PHP 8.3+ with the `pgsql`, `mbstring`, `xml`, `curl`, `bcmath`, `zip`, `gd`, `intl`
  extensions
- [Composer](https://getcomposer.org/) 2.x
- Node.js LTS + npm (installing via [nvm](https://github.com/nvm-sh/nvm) is recommended
  over a system package)
- PostgreSQL 16 (a local instance for development; production points at AWS instead)

## Setup

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate
```

Create a local Postgres role and database matching your `.env` (adjust names/password as
you like, then update `.env` to match):

```bash
sudo -u postgres psql -c "CREATE ROLE eb_portfolio WITH LOGIN PASSWORD 'change-me' CREATEDB;"
sudo -u postgres createdb -O eb_portfolio eb_portfolio
```

Then migrate and seed:

```bash
php artisan migrate --seed
```

## Running

```bash
composer run dev
```

This runs `php artisan serve`, a queue listener, `php artisan pail` (log tailing), and
`npm run dev` (Vite) concurrently — it's Laravel's default `dev` script. To run pieces
individually instead:

```bash
php artisan serve
npm run dev
```

## Testing

```bash
php artisan test
```

## Formatting

```bash
vendor/bin/pint
```

## Project structure — what's different from Laravel 5.8

If you're used to Laravel 5.8, the biggest change is that most of the ceremony files are
gone:

- **No `app/Http/Kernel.php`, `app/Console/Kernel.php`, or `app/Exceptions/Handler.php`.**
  Middleware, console scheduling, and exception handling are all configured in
  `bootstrap/app.php` via a fluent builder (`Application::configure(...)->withMiddleware()
  ->withExceptions()`).
- **No `app/Providers/RouteServiceProvider.php`, `EventServiceProvider.php`, etc.** as
  boilerplate — only `AppServiceProvider` ships by default; routes are auto-loaded from
  `routes/web.php` (and `routes/console.php` for Artisan commands) without a service
  provider in between.
- **Models increasingly use PHP 8 attributes instead of protected properties** — e.g.
  `#[Fillable([...])]` and `#[Hidden([...])]` above the class instead of
  `protected $fillable = [...]`. See `app/Models/User.php` and `app/Models/Project.php`.
- **`casts()` is a method, not a `protected $casts` array** (introduced in Laravel 11).
- **Vite instead of Laravel Mix/Elixir** for asset bundling — `@vite([...])` in Blade
  instead of `{{ mix('...') }}`.
- **`routes/api.php` doesn't exist until you ask for it** (`php artisan install:api`) —
  this app doesn't have an API surface yet.

## Configuration map — how the pieces tie together

| Concern | Configured in |
|---|---|
| Laravel middleware, exception handling, console scheduling | `bootstrap/app.php` |
| Environment values (DB, mail, app name, etc.) | `.env` (copy of `.env.example`) |
| Database connection | `config/database.php`, reading `DB_*` from `.env` |
| Vite entrypoints (which CSS/SASS/JS files get bundled) | `vite.config.js` |
| Tailwind design tokens (colors, fonts) and plugins | `resources/css/app.css` — `@theme { ... }` block and `@plugin` directives (Tailwind v4 is CSS-first; there is no `tailwind.config.js`) |
| Custom SASS partials (variables, mixins, base, components) | `resources/sass/app.scss` imports `_variables.scss`, `_mixins.scss`, `_base.scss`, `_components.scss` |
| jQuery/Alpine.js initialization | `resources/js/app.js` |
| Which compiled assets load on a page | `@vite([...])` calls in `resources/views/layouts/app.blade.php` and `layouts/guest.blade.php` |
| Site-wide header/footer chrome | `resources/views/partials/header.blade.php`, `partials/footer.blade.php` |
| Routes | `routes/web.php` (public + protected), `routes/auth.php` (Breeze) |
| Auth scaffolding | `laravel/breeze` (installed as a dev dependency, not framework core) |
| Code formatting rules | Laravel Pint's default `laravel` preset (no custom `pint.json` needed) |
| AI agent guidelines/MCP tools | `CLAUDE.md`, `.mcp.json`, `.claude/skills/` (via Laravel Boost) |

Request flow for the homepage, as an example: `routes/web.php` → `HomeController::index()`
→ queries `Project` (via scopes defined in `app/Models/Project.php`) → renders
`resources/views/home.blade.php` → which extends `<x-app-layout>` (→
`layouts/app.blade.php`, including the header/footer partials) → styled by the Tailwind
utilities compiled from `resources/css/app.css` plus the custom SASS component classes
compiled from `resources/sass/app.scss` → the mobile nav toggle is wired up by
`resources/js/app.js` (jQuery).

## Setup log

`.claude/setup-log.md` has a full log of the commands run and decisions made while
scaffolding this project (toolchain install, version pinning, Tailwind v4 migration
notes, etc.).

## Next steps

- Personalize `APP_NAME` and the homepage copy in `resources/views/home.blade.php`
  (currently placeholder text).
- Add real resume/cover-letter/about content — these are static Blade for now; making
  them editable is a good candidate for the next phase, once you're ready to build the
  auth-gated content editor.
- Provision the AWS-hosted PostgreSQL instance for production and point the deployed
  `.env` at it (no code changes needed — only `DB_*` values).
- Add a project image storage disk (currently `image_path` on `Project` is unused).
