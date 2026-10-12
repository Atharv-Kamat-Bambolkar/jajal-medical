
# Jajal Medical Case Management System

A web-based Medical Case Management System built with Laravel and MySQL. The application helps manage medical cases through role-based access, case tracking, dashboard summaries, and a token-authenticated REST API.

> **Note:** This project uses fictional patient references and demo data. Do not enter real patient information.

## Features

### Medical Case Management
- Create, view, edit, and delete medical cases.
- Assign a unique case number to each case.
- Store a dummy patient reference, surgeon name, implant type, status, priority, and optional surgery date.
- Record the user who created each case.
- Search cases by case number or surgeon name.
- Filter cases by status.
- Display cases with pagination.

### Dashboard
- Total medical cases.
- Cases in Planning.
- Cases in In Review.
- Cases in Approved.
- Cases in Completed.

### Role-Based Access
- **Admin:** View, create, edit, and delete cases.
- **Viewer:** View cases without modifying them.

### REST API
- Token-based authentication using Laravel Sanctum.
- Login and logout endpoints.
- Paginated medical case listing.
- Case details, creation, updates, and deletion.
- Server-side role authorization and request validation.

## Technology Stack

- **Backend:** Laravel 13
- **Language:** PHP
- **Database:** MySQL
- **Authentication:** Laravel authentication and Sanctum
- **Frontend:** Blade templates, HTML, CSS, Bootstrap
- **Testing:** PHPUnit / Laravel test suite
- **Development tools:** Composer, Node.js, npm

## Requirements

Install the following before running the application:

- PHP compatible with the project's Composer dependencies.
- Composer
- MySQL
- Node.js and npm
- Git (optional for local execution, required for GitHub workflows)

## Installation and Setup

### 1. Clone the repository

```bash
git clone <YOUR_PUBLIC_GITHUB_REPOSITORY_URL>
cd jajal-medical
```

Replace the placeholder with your actual public repository URL after publishing the project.

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Configure environment variables

Create your local environment file if it does not exist:

```bash
copy .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure the database settings in `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jajal_medical
DB_USERNAME=root
DB_PASSWORD=
```

Update the database username and password to match your local MySQL configuration.

Create the `jajal_medical` database in MySQL before continuing.

### 4. Run database migrations and seed demo data

```bash
php artisan migrate
php artisan db:seed
```

The seeder provides demo accounts and fictional medical case records.

Do not run `php artisan migrate:fresh` on a database containing data you need to preserve.

### 5. Build frontend assets

```bash
npm run build
```

### 6. Start the application

```bash
php artisan serve
```

Open the application at:

http://127.0.0.1:8000

## Demo Accounts

The following accounts are intended for local development and demonstration only.

| Role | Email | Password |
|---|---|---|
| Admin | admin@jajalmedical.test | Admin@12345 |
| Viewer | viewer@jajalmedical.test | Viewer@12345 |

Change demo credentials before using any deployed environment. Never use these credentials for a public production service.

## REST API Documentation

Base URL:

```text
http://127.0.0.1:8000/api
```

### Authentication

| Method | Endpoint | Description | Authentication |
|---|---|---|---|
| POST | `/login` | Authenticate and receive a token | None |
| POST | `/logout` | Revoke the current token | Bearer token |

### Medical Cases

| Method | Endpoint | Description | Permission |
|---|---|---|---|
| GET | `/cases` | List cases with pagination | Admin, Viewer |
| GET | `/cases/{id}` | Retrieve a case | Admin, Viewer |
| POST | `/cases` | Create a case | Admin |
| PUT | `/cases/{id}` | Update a case | Admin |
| DELETE | `/cases/{id}` | Delete a case | Admin |

Protected endpoints require the token returned by login.

Include this HTTP header:

```text
Authorization: Bearer YOUR_ACCESS_TOKEN
Accept: application/json
```

### Login Example

Send a POST request to `/api/login` with JSON:

```json
{
  "email": "admin@jajalmedical.test",
  "password": "Admin@12345"
}
```

Use the returned token as the Bearer token for protected requests.

### List and Filter Cases

```text
GET /api/cases
GET /api/cases?search=JM-0001
GET /api/cases?status=Planning
```

The API returns case data and pagination information.

### Example Case Request

```json
{
  "case_number": "API-DEMO-001",
  "patient_reference": "PAT-DEMO-001",
  "surgeon_name": "Dr. Demo",
  "implant_type": "Test Implant",
  "status": "Planning",
  "priority": "Medium",
  "surgery_date": null
}
```

Use a unique case number for each new case. Allowed statuses are Draft, Planning, In Review, Approved, Completed, and Cancelled. Allowed priorities are Low, Medium, and High.

## Automated Testing

Run the complete test suite:

```bash
php artisan test
```

The current test suite includes authentication, profile, application, and medical case API tests.

The six assignment-specific API feature tests cover:
1. Valid login.
2. Invalid login.
3. Guest access restriction.
4. Admin case creation.
5. Duplicate case number rejection.
6. Viewer deletion restriction.

The suite currently reports 31 passing tests.

## Documentation

- [Database Documentation](docs/database.md)
- [Requirements Traceability](docs/traceability.md)

## Security Notes

- Never commit `.env` or application secrets.
- Use fictional data for demonstrations and testing.
- Keep passwords hashed and use authenticated API tokens.
- Do not deploy demo credentials to production.
- Configure production environment variables and HTTPS before deployment.

## Laravel Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)
- [Laravel Testing](https://laravel.com/docs/testing)

## License

This project is developed as an application assignment. Laravel and its dependencies retain their respective licenses.
