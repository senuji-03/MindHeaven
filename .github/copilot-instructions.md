# MindHeaven Copilot Instructions

## Architecture Overview
MindHeaven is a PHP-based mental health platform for university students using MVC architecture:
- **Controllers** (`app/controllers/`): Handle HTTP requests, business logic, data fetching via raw SQL
- **Models** (`app/models/`): Encapsulate database operations using PDO prepared statements
- **Views** (`app/views/`): Server-side rendered PHP templates with embedded HTML/CSS/JS
- **Core** (`core/`): Router, Database singleton, autoloader, view helper
- **Config** (`config/config.php`): Database credentials, base paths

Entry point: `public/index.php` routes requests via custom Router class.

## Key Patterns
- **Routing**: Use `Router` class in `public/index.php` for GET/POST mappings to `Controller@method`
- **Database**: Singleton PDO connection via `Database::getConnection()`. Use prepared statements with named parameters (e.g., `:id`)
- **Views**: Call `view('path/to/view', $data)` to render; data extracted as variables
- **Autoloading**: Classes in `app/controllers/`, `app/models/`, `core/` auto-loaded by filename match
- **User Roles**: 'admin', 'counselor', 'undergrad', 'university_rep' with role-specific tables (e.g., `counselors`, `undergraduate_students`)

## Database Schema
Normalized MySQL schema with foreign keys. Key tables:
- `users`: Core auth (id, username, role)
- `undergraduate_students`, `counselors`: Extended profiles linked by user_id
- `appointments`: Bookings between students and counselors
- `events`: Counselor-managed events
- `mood_records`: Student mood tracking
- `forum_*`: Discussion system
- `resources`: Educational materials with categories

See `database/DATABASE_SCHEMA_DOCUMENTATION.md` for full relationships.

## Development Workflow
- **Setup**: Deploy under XAMPP htdocs, access via `http://localhost/MindHeaven/public`
- **Database**: Import schemas from `database/*.sql`; default MySQL root/no password
- **Testing**: Manual via browser; simple test scripts like `test_event_creation.php` for DB ops
- **Debugging**: Use `error_log()` for logging; views include HTML for quick UI checks
- **File Structure**: Controllers in `app/controllers/`, views in `app/views/{role}/`, models in `app/models/`

## Conventions
- **Controllers**: Methods return void; use `view()` for rendering, `header()` for redirects
- **Models**: Constructor gets DB connection; methods return arrays/objects or false on error
- **SQL**: Complex queries with JOINs for user management (see `AdminControl@manageUsers`)
- **Error Handling**: Try-catch in controllers; die() or http_response_code() for failures
- **Security**: Session-based auth via `core/Auth.php`; no CSRF tokens visible in current code

## Examples
- Add route: `$router->get('/new-path', 'Controller@method')` in `public/index.php`
- Fetch data: `$stmt = $pdo->prepare("SELECT * FROM table WHERE id = :id"); $stmt->execute(['id' => $value])`
- Render view: `view('admin/dashboard', ['users' => $userArray])` in controller method