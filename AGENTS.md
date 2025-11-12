# Agent Guidelines for ForgeApp

## Stack
Laravel 12 (PHP 8.2+) backend with Inertia.js, Vue 3, Tailwind CSS frontend. Uses Pest for testing, Laravel Pint for formatting, Jetstream for auth.

## Commands
- **Build**: `npm run build` (frontend), no backend build needed
- **Lint**: `composer pint` (PHP formatting)
- **Test all**: `composer test` or `php artisan test`
- **Test single**: `php artisan test --filter=TestName` or `php artisan test tests/Feature/SomeTest.php`
- **Dev**: `composer dev` (runs server, queue, logs, vite concurrently)

## Code Style
- **PHP**: PSR-4 autoloading, type hints required, prefer strict types when possible
- **Imports**: Group use statements (Models, Facades, External), alphabetize within groups
- **Naming**: PascalCase (classes), camelCase (methods/properties), snake_case (DB columns, routes)
- **Models**: Use `$fillable` for mass assignment, Eloquent relationships over raw queries
- **Controllers**: Keep thin, delegate business logic to Actions or Services
- **Vue**: Composition API with `<script setup>`, use Inertia Link component for navigation
- **Styling**: Tailwind utility classes, maintain responsive design (sm/md/lg breakpoints)
- **Error Handling**: Use Laravel exceptions, validate at FormRequest or controller level
- **Testing**: Pest syntax, use Feature tests for HTTP, Unit for isolated logic
