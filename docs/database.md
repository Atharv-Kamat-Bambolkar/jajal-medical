
# Database Documentation

## 1. Project Database

The Jajal Medical Case Management System uses MySQL as its relational database and Laravel Eloquent ORM for database operations.

## 2. Tables

### 2.1 users

Stores application users and their authentication information.

| Column | Description |
|---|---|
| id | Primary key |
| name | User's name |
| email | User's unique email address |
| password | Hashed password |
| role | User role: Admin or Viewer |
| email_verified_at | Email verification timestamp, if used |
| remember_token | Authentication remember token |
| created_at | Record creation timestamp |
| updated_at | Last update timestamp |

### 2.2 medical_cases

Stores medical case management records. Only fictional patient references should be used.

| Column | Description |
|---|---|
| id | Auto-incrementing primary key |
| created_by | Foreign key referencing users.id |
| case_number | Required, unique case identifier |
| patient_reference | Required dummy patient reference |
| surgeon_name | Required surgeon name |
| implant_type | Required implant type |
| status | Draft, Planning, In Review, Approved, Completed, or Cancelled |
| priority | Low, Medium, or High |
| surgery_date | Optional surgery date |
| created_at | Record creation timestamp |
| updated_at | Last update timestamp |

## 3. Relationships

Each medical case belongs to the user who created it.

- `medical_cases.created_by` references `users.id`.
- The relationship is implemented through the `creator()` method in the MedicalCase model.
- The `created_by` field is automatically assigned from the authenticated user's ID when a new case is created.

## 4. Constraints and Validation

- Case numbers must be unique.
- Required fields are validated before saving.
- Status and priority values are restricted to the permitted options.
- Surgery date is optional and must be a valid date when supplied.
- Admin users can create, update, and delete cases.
- Viewer users can view cases but cannot modify them.
- Foreign-key constraints maintain referential integrity.

## 5. Demo Data

The application includes seeded demo users and fictional medical case records for development and testing.

Do not use real patient information in the demo database.
