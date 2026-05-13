# Database Setup Guide

## Overview
This guide explains how to set up the database for the RH (Human Resources) Management System using CodeIgniter 4 migrations and seeders.

## Database Structure
The database consists of 5 tables with the following dependency order:
1. **departments** - Organization departments (no dependencies)
2. **type_conge** - Leave types (no dependencies)
3. **employees** - Employee data (depends on departments)
4. **solde** - Leave balances (depends on employees and type_conge)
5. **conge** - Leave requests (depends on employees and type_conge)

## Prerequisites
- CodeIgniter 4 framework installed
- Database configured in `.env` file:
  ```
  database.default.hostname = localhost
  database.default.database = rh_system
  database.default.username = root
  database.default.password = 
  database.default.DBDriver = MySQLi
  ```

## Running Migrations

### Step 1: Run all migrations
```bash
php spark migrate
```

This will create all 5 tables in the correct order, respecting foreign key dependencies.

### Step 2: Verify migrations
```bash
php spark migrate:status
```

You should see all 5 migrations listed as "2025-06-01-12xxxx" with batch "1".

## Seeding Data

### Step 1: Run the seeder
```bash
php spark db:seed InitialSeeder
```

This will populate the database with:
- **4 departments**: IT, Finance, Marketing, RH
- **4 leave types**: Congé annuel (30 days), Congé maladie (10 days), Congé spécial (5 days), Congé sans solde (0 days)
- **7 employees**:
  - Soa Rakoto (employe, IT)
  - Marie Rabe (rh, RH)
  - Tsiry Fidy (employe, Finance)
  - Haja Andria (employe, Marketing)
  - Admin Super (admin, RH)
  - Noro Ramarao (employe, IT)
  - Ketaka Feno (employe, Finance)
- **28 solde records** (7 employees × 4 leave types for current year)
- **4 leave requests** (sample data for testing)

### Step 2: Test credentials

You can log in with the following credentials:

#### Employee
- Email: `soa.rakoto@techmada.mg`
- Password: `emp123456`

#### RH Staff
- Email: `marie.rabe@techmada.mg`
- Password: `rh123456`

#### Administrator
- Email: `admin@techmada.mg`
- Password: `admin123`

## Database Schema Details

### departments Table
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- name (VARCHAR(100), UNIQUE)
- description (TEXT, nullable)
- created_at, updated_at (DATETIME)
```

### type_conge Table
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- libelle (VARCHAR(100)) - Leave type name
- jours_annuels (INT) - Annual days
- deductible (BOOLEAN) - Whether it deducts from balance
- created_at, updated_at (DATETIME)
```

### employees Table
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- name (VARCHAR(100)) - Last name
- prenom (VARCHAR(100)) - First name
- email (VARCHAR(150), UNIQUE)
- role (ENUM: admin, rh, employe)
- date_embauche (DATE) - Hire date
- actif (BOOLEAN)
- id_department (INT, FK to departments)
- mdp (VARCHAR(255)) - Password hash (bcrypt)
- created_at, updated_at (DATETIME)
```

### solde Table
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- id_employee (INT, FK to employees)
- id_type_conge (INT, FK to type_conge)
- annee (INT) - Year
- jours_attribues (INT) - Days allocated
- jours_pris (INT) - Days taken
- restant (INT) - Remaining days (calculated: jours_attribues - jours_pris)
- pris (INT) - Additional field for tracking
- created_at, updated_at (DATETIME)
- Foreign key: (id_employee, id_type_conge, annee) as composite index
```

### conge Table
```sql
- id (INT, PRIMARY KEY, AUTO_INCREMENT)
- id_employee (INT, FK to employees)
- id_type_conge (INT, FK to type_conge)
- date_debut (DATE) - Start date
- date_fin (DATE) - End date
- nb_jours (INT) - Number of days
- motif (TEXT, nullable) - Reason
- status (ENUM: en_attente, approuvee, refusee, annulee)
- commentaire (TEXT, nullable) - Comments/rejection reason
- traite_par (VARCHAR(100), nullable) - Processed by (RH name)
- created_at, updated_at (DATETIME)
```

## Workflow: Leave Request Status Flow

A leave request follows this status progression:

```
en_attente (Pending)
    ↓
[RH Review]
    ├→ approuvee (Approved) → Balance deducted
    ├→ refusee (Refused) → Balance unchanged
    └→ (no action) → Remains pending
    
annulee (Cancelled) - Can be set at any point
```

## Working with Models

The following models are available in `app/Models/`:

### EmployeeModel
```php
$model = new \App\Models\EmployeeModel();

// Examples
$employee = $model->find($id);
$rh_staff = $model->getRH();
$all_active = $model->getAllWithDepartments();
$auth = $model->authenticate('email@example.com', 'password');
```

### ClientModel
```php
$model = new \App\Models\TypeCongeModel();

$types = $model->findAll();
$deductible = $model->getDeductible();
$annuel = $model->getByLibelle('Congé annuel');
```

### DepartmentModel
```php
$model = new \App\Models\DepartmentModel();

$dept = $model->find($id);
$count = $model->countEmployees($id);
$stats = $model->getStats($id);
```

### CongeModel
```php
$model = new \App\Models\CongeModel();

$pending = $model->getPending();
$employee_history = $model->getByEmployee($id);
$has_conflict = $model->hasOverlap($emp_id, $start, $end);
$model->approve($leave_id, 'Marie Rabe');
$model->refuse($leave_id, 'Motif de refus', 'Marie Rabe');
```

### SoldeModel
```php
$model = new \App\Models\SoldeModel();

$balance = $model->getByEmployeeAndType($emp_id, $type_id);
$all_balances = $model->getByEmployee($emp_id);
$critical = $model->getCriticalBalance(2025, 2); // ≤ 2 days
$model->updateAfterApproval($emp_id, $type_id, 5); // Deduct 5 days
```

## Troubleshooting

### Migration Fails
- Check database connection in `.env`
- Ensure database exists
- Check file permissions in `app/Database/Migrations/`

### Seeder Fails
- Verify migrations ran successfully first
- Check that migrations created all tables
- Ensure seeder file is in `app/Database/Seeds/`

### Foreign Key Constraints
- Delete in reverse order: conge → solde → employees → type_conge → departments
- Ensure CASCADE delete rules are enabled

## Reset Database

To fully reset and reinitialize:

```bash
# Rollback all migrations
php spark migrate:rollback --batch=0

# Re-run migrations
php spark migrate

# Re-seed data
php spark db:seed InitialSeeder
```

## Notes

- Passwords are hashed using PHP's `password_hash()` with BCRYPT algorithm
- All tables include `created_at` and `updated_at` timestamps for audit trails
- Foreign keys use CASCADE delete for data integrity
- Solde records are auto-created for new employees by SoldeModel::initializeForEmployee()
- Leave overlaps are prevented by CongeModel::hasOverlap() method
