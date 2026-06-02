# Authentication Database Design

## Overview
This document describes the authentication and authorization system for the ERP application using a Role-Based Access Control (RBAC) model.

## Database Schema

### 1. Users Table
The main users table storing user credentials and authentication data.

```
users
├── id (PK, bigint)
├── name (string)
├── email (unique, string)
├── email_verified_at (timestamp, nullable)
├── password (string, hashed)
├── remember_token (string, nullable)
├── created_at (timestamp)
└── updated_at (timestamp)
```

**Purpose:** Stores user account information and authentication credentials.

---

### 2. Roles Table
Defines available roles in the system.

```
roles
├── id (PK, bigint)
├── name (string, unique) - e.g., "Administrator", "Manager"
├── slug (string, unique) - e.g., "admin", "manager"
├── description (text, nullable)
├── created_at (timestamp)
└── updated_at (timestamp)
```

**Purpose:** Defines the types of roles available in the system.

**Default Roles:**
- **Administrator (admin)** - Full system access and control
- **Manager (manager)** - Department and team management
- **Employee (employee)** - Regular employee access
- **Viewer (viewer)** - Read-only access

---

### 3. Role_User Pivot Table
Many-to-many relationship between users and roles.

```
role_user
├── id (PK, bigint)
├── user_id (FK → users.id, onDelete: cascade)
├── role_id (FK → roles.id, onDelete: cascade)
├── created_at (timestamp)
├── updated_at (timestamp)
└── unique(user_id, role_id)
```

**Purpose:** Associates users with roles (one user can have multiple roles).

---

## Relationships

### User Model
```php
// Get all roles for a user
$user->roles();

// Check if user has a specific role
$user->hasRole('admin');

// Check if user has any of multiple roles
$user->hasAnyRole(['admin', 'manager']);
```

### Role Model
```php
// Get all users with a specific role
$role->users();
```

---

## Usage Examples

### Assigning Roles to Users
```php
use App\Models\User;
use App\Models\Role;

$user = User::find(1);
$adminRole = Role::where('slug', 'admin')->first();

// Assign single role
$user->roles()->attach($adminRole);

// Assign multiple roles
$user->roles()->sync([
    $adminRole->id,
    $managerRole->id,
]);
```

### Checking User Permissions
```php
$user = User::find(1);

// Check single role
if ($user->hasRole('admin')) {
    // User is admin
}

// Check multiple roles
if ($user->hasAnyRole(['admin', 'manager'])) {
    // User is admin or manager
}
```

### Creating and Using Seeders
```bash
# Run all seeders (including RoleSeeder)
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=RoleSeeder

# Reset database and re-seed
php artisan migrate:fresh --seed
```

---

## Migration Information

### Created Migrations
1. **create_roles_table.php** - Roles table
2. **create_role_user_table.php** - Pivot table for user-role relationship

### Migration Commands
```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Reset and migrate
php artisan migrate:fresh
```

---

## Models Location
- `app/Models/User.php` - User model with role relationships
- `app/Models/Role.php` - Role model with user relationships

---

## Seeders Location
- `database/seeders/RoleSeeder.php` - Role seeder
- `database/seeders/DatabaseSeeder.php` - Main seeder (calls RoleSeeder)

---

## Future Enhancements
- Add **Permissions** table for granular access control
- Add **Policies** for authorization checks
- Implement middleware for role-based route protection
- Add audit logging for role assignments
- Implement permission caching for performance

---

## Database Diagram

```
┌─────────────────────┐
│      users          │
├─────────────────────┤
│ id (PK)             │
│ name                │
│ email               │
│ password            │
│ created_at          │
│ updated_at          │
└─────────────────────┘
          │
          │ many-to-many
          │
     ┌────┴────┐
     │          │
┌────────────────────┐      ┌─────────────────────┐
│   role_user        │      │      roles          │
├────────────────────┤      ├─────────────────────┤
│ id (PK)            │      │ id (PK)             │
│ user_id (FK)       ├─────→│ name                │
│ role_id (FK)       ├─────→│ slug                │
│ created_at         │      │ description         │
│ updated_at         │      │ created_at          │
└────────────────────┘      │ updated_at          │
                            └─────────────────────┘
```

---

## Version History
- **v1.0** (June 2, 2026) - Initial authentication design with users and roles
