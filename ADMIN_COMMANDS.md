# Admin User Management Commands

This Laravel application includes custom Artisan commands for managing admin users.

## Available Commands

### 1. Create or Make Admin User
```bash
php artisan admin:make user@example.com
```

**Options:**
- `--name="John Doe"` - Name for new users (will prompt if not provided)
- `--password="secret123"` - Password for new users (will prompt securely if not provided)

**Examples:**
```bash
# Make existing user admin
php artisan admin:make existing@user.com

# Create new admin user with name and password
php artisan admin:make new@admin.com --name="Admin User" --password="secure123"

# Create new admin (will prompt for name and password)
php artisan admin:make new@admin.com
```

### 2. List All Admin Users
```bash
php artisan admin:list
```

This command displays a table with all current admin users showing:
- ID
- Name
- Email
- Status
- Created At

### 3. Revoke Admin Privileges
```bash
php artisan admin:revoke user@example.com
```

**Options:**
- `--to=user` - Role to assign after revoking admin (default: user)
- `--to=translator` - Make user a translator instead

**Examples:**
```bash
# Revoke admin and make regular user
php artisan admin:revoke admin@example.com --to=user

# Revoke admin and make translator
php artisan admin:revoke admin@example.com --to=translator
```

## Features

- **Smart User Detection**: Automatically detects if user exists or needs to be created
- **Interactive Prompts**: Prompts for missing information when creating new users
- **Confirmation Dialogs**: Asks for confirmation before revoking admin privileges
- **Status Display**: Shows current user information and confirms changes
- **Error Handling**: Provides clear error messages for invalid operations
- **Security**: Uses secure password prompting for new user creation

## User Roles

The application supports three user roles:
- `user` - Regular user (default)
- `translator` - Translator with special permissions
- `admin` - Administrator with full access
