# Laravel 12 Application - AI Agent Instructions

## Project Overview
A Laravel 12 web application with authentication, event management, and product browsing features. Uses SQLite (default), Blade templates for server-side rendering, and Vite for frontend asset bundling with Tailwind CSS.

## Architecture & Directory Structure

### Core Directories
- **`app/Http/Controllers/`** - Route handlers (`AuthController`, `EventController`, `DashboardController`)
- **`app/Models/`** - Eloquent ORM models (`User` with factory-based timestamps and password hashing)
- **`routes/`** - Two main files: `web.php` (Blade templates) and `api.php` (currently unused)
- **`resources/views/`** - Blade templates organized by feature (auth, events, products)
- **`config/`** - Framework configuration (database, cache, session, etc.)

### Database Pattern
- Uses Laravel migrations in `database/migrations/` with numbered timestamps
- Eloquent models with `HasFactory` trait for seeding
- Default database connection: SQLite (via `DB_CONNECTION` in `.env`)
- Test environment: `:memory:` SQLite database (see `phpunit.xml`)

## Key Development Workflows

### Setup
```bash
composer install
@php artisan key:generate
@php artisan migrate --force
npm install && npm run build
```
Or use composer script: `composer setup`

### Local Development
```bash
composer run dev
# Runs concurrent: artisan serve, queue:listen, pail logs, and vite dev
```

### Testing
```bash
composer run test
# Clears config cache, then runs phpunit with Unit + Feature test suites
```

### Build & Deployment
- Frontend: `npm run build` (Vite + Tailwind CSS)
- Backend: Standard Laravel deployment (no additional build step)

## Code Patterns & Conventions

### Controllers
- **Request validation** in controller methods using `$request->validate()` (e.g., `AuthController::register`)
- **Return views** or `RedirectResponse` from POST/form actions
- **No API responses** - routes return Blade views exclusively

### Eloquent Models
- Use `$fillable` array for mass assignment protection
- `User` model: casts `email_verified_at` as datetime, `password` as hashed
- Password hashing: `Hash::make()` in controllers, automatic casting in model

### Blade Templates
- Located in `resources/views/` with subdirectories by feature
- Global variables passed from controllers: `view('products', ['busca' => $busca])`
- Layouts inferred from view structure (check `resources/views/layouts/` if needed)

### Frontend
- **Tailwind CSS 4** via `@tailwindcss/vite` plugin
- **Vite** configured in `vite.config.js` with Laravel plugin
- CSS entry point: `resources/css/app.css`
- JS entry point: `resources/js/app.js`
- Ignore cache during dev: `storage/framework/views/**` excluded from Vite watch

## Test Configuration

### Test Structure
- **Unit tests**: `tests/Unit/` - single component testing
- **Feature tests**: `tests/Feature/` - request/response workflows
- Base class: `Tests\TestCase` (minimal, inherits from `Illuminate\Foundation\Testing\TestCase`)

### Testing Environment (`phpunit.xml`)
- Database: `:memory:` SQLite (fast, isolated)
- Cache: array driver (in-process)
- Queue: sync driver (no background jobs in tests)
- Mail: array driver (no email delivery)

## Route Structure

### Web Routes (`routes/web.php`)
- `GET /` - Welcome page
- `GET /teste` - Event listing (`EventController::index`)
- `GET /events/create` - Event creation form (`EventController::create`)
- `GET /produtos` - Product list with search query parameter
- `GET /produtos_teste/{id?}` - Product detail (ID optional)

### API Routes (`routes/api.php`)
- Currently empty - future API development area

## Common Tasks

### Adding a New Controller
1. Create in `app/Http/Controllers/YourController.php`
2. Extend `Controller` base class
3. Add methods returning views or RedirectResponse
4. Register routes in `routes/web.php`

### Creating a Database Model
1. Create migration: `php artisan make:migration create_table_name`
2. Define schema in `database/migrations/`
3. Create model in `app/Models/YourModel.php` with appropriate `$fillable` array
4. Run: `php artisan migrate`

### Adding a Blade Template
1. Create in `resources/views/feature-name/template.blade.php`
2. Pass data from controller: `view('feature-name.template', ['key' => $value])`
3. Reference via `@` directives (@foreach, @if, {{ }}, etc.)

### Frontend Development
- Start dev server: `npm run dev` (via Vite)
- Edit CSS in `resources/css/` (Tailwind processed)
- Edit JS in `resources/js/` (module bundling)
- Hot reload on save (configured in Vite)

## Dependencies & Versions
- **PHP**: ^8.2
- **Laravel**: ^12.0 (latest, with streamlined auth, Pest alternatives)
- **Frontend**: Vite 7, Tailwind CSS 4, axios
- **Testing**: PHPUnit 11.5
- **Dev tools**: Pint (linting), Tinker (REPL), Pail (logs)

## Notes for AI Agents
- Always check `AUTH_GUARD` in config if adding auth features
- Database migrations are versioned; don't manually edit completed ones
- Blade syntax uses `{{ }}` for escaping, `{!! !!}` for raw HTML
- Session driver: array in tests, file-based in dev/production
- No API middleware configured; add to `routes/api.php` if building REST endpoints
