# Laravel Blog - Agent Guidelines

## Commands
- **Build**: `npm run build` (frontend assets)
- **Lint**: `./vendor/bin/pint` (PHP code style)
- **Test**: `composer test` or `php artisan test`
- **Single test**: `php artisan test --filter TestName` or `php artisan test tests/Feature/ExampleTest.php`
- **Dev server**: `composer dev` (runs server, queue, logs, and vite)

## Code Style Guidelines
- **PHP**: Follow Laravel conventions with PSR-12, use Laravel Pint for formatting
- **Imports**: Order: external libraries, then internal (App\), use alphabetical sorting
- **Naming**: PascalCase for classes, camelCase for methods/variables, snake_case for database columns
- **Types**: Use strict typing and PHP 8.2+ features (return types, readonly properties)
- **Documentation**: Use PHPDoc blocks for methods with proper @param and @return tags
- **Error handling**: Use Laravel's exception handling, validate requests, return proper HTTP responses
- **Database**: Use Eloquent models with proper fillable arrays, migrations with descriptive names
- **Testing**: Write both Unit and Feature tests, use factories for test data