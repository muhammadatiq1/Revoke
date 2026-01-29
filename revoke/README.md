# Revoke - Shadow IT & Offboarding Manager

A powerful Laravel 11 B2B SaaS application for tracking employee software usage and managing offboarding processes with automated "Kill List" generation.

## Features

- **Employee Management**: Track all employees with their departments, status, and avatar profiles
- **Software Inventory**: Maintain a comprehensive list of software tools with cost and risk level tracking
- **Access Tracking**: See which employees have access to which applications
- **Offboarding Automation**: One-click offboarding that generates automatic revocation tasks for all software access
- **Dashboard Analytics**: Real-time metrics including monthly spend, pending tasks, and employee counts
- **Risk Assessment**: Identify high-risk applications and prioritize access revocation

## Tech Stack

- **Backend**: Laravel 11
- **Frontend**: Blade Templates, Tailwind CSS 4, Alpine.js
- **Database**: MySQL
- **Package Manager**: Composer, npm

## Quick Start

### Prerequisites
- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js & npm

### Installation

1. **Navigate to project**
   ```bash
   cd revoke
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   # Edit .env with your database credentials
   php artisan key:generate
   ```

4. **Setup database**
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Build assets**
   ```bash
   npm run build
   ```

6. **Start development server**
   ```bash
   php artisan serve
   ```

7. **In another terminal, watch assets**
   ```bash
   npm run dev
   ```

Visit `http://localhost:8000/dashboard` to access the application.

## Database Schema

### Employees Table
- `id` (Primary Key)
- `name` (string)
- `email` (string, unique)
- `department` (string)
- `status` (enum: 'active', 'terminated')
- `avatar_url` (nullable string)
- `created_at`, `updated_at` (timestamps)

### Softwares Table
- `id` (Primary Key)
- `name` (string)
- `monthly_cost` (decimal)
- `risk_level` (enum: 'low', 'high')
- `website_url` (nullable string)
- `created_at`, `updated_at` (timestamps)

### Employee_Software Table (Pivot)
- `id` (Primary Key)
- `employee_id` (Foreign Key)
- `software_id` (Foreign Key)
- `assigned_at` (timestamp)

### Offboarding_Tasks Table
- `id` (Primary Key)
- `employee_id` (Foreign Key)
- `software_id` (Foreign Key)
- `status` (enum: 'pending', 'revoked')
- `revoked_at` (nullable timestamp)

## Models & Relationships

**Employee**
```php
->belongsToMany(Software::class)
->hasMany(OffboardingTask::class)
```

**Software**
```php
->belongsToMany(Employee::class)
->hasMany(OffboardingTask::class)
```

**OffboardingTask**
```php
->belongsTo(Employee::class)
->belongsTo(Software::class)
```

## Routes

- `GET /dashboard` - Dashboard with analytics
- `GET /employees` - List all employees
- `GET /employees/{id}` - Employee details with software access
- `GET /softwares` - List all software
- `GET /softwares/{id}` - Software details with users
- `GET /offboarding` - Offboarding tasks
- `GET /offboarding/{employee}` - Employee's kill list
- `POST /offboarding/{employee}` - Initiate offboarding
- `PATCH /offboarding/revoke/{task}` - Mark task revoked

## Sample Data

The seeders create:
- **10 realistic softwares** (Slack, Jira, Zoom, Figma, AWS, GitHub Enterprise, Microsoft 365, Notion, Datadog, Stripe)
- **20 employees** across 6 departments
- **3-5 software assignments** per employee
- **2 terminated employees** with offboarding tasks

## Key Features

### Dashboard
- Total Monthly Spend (sum of software costs for active employees)
- Pending Offboarding Tasks count
- Active Employees count
- Recent activity feed (latest 5 tasks)

### Employee Management
- Grid/list view of all employees
- Individual employee profiles with software assignments
- Cost per employee calculations
- Risk assessment

### Offboarding Process
1. Select an employee to offboard
2. System creates offboarding tasks for all assigned software
3. Mark each application access as revoked
4. Track progress and completion

### Software Tracking
- Monitor active users per application
- Track monthly costs
- Identify high-risk applications
- Calculate cost savings

## UI Design

- Modern clean interface with gray/white color scheme
- Responsive sidebar navigation
- Top navigation with search and user profile
- Tailwind CSS for styling
- Alpine.js for interactivity
- Status badges and risk indicators

## Controllers

- **DashboardController**: Analytics and metrics
- **EmployeeController**: List and detail views
- **SoftwareController**: Software management
- **OffboardingController**: Offboarding workflow

## Future Enhancements

- Email notifications for offboarding tasks
- Audit logs for compliance
- Bulk offboarding operations
- Cost optimization reports
- Identity management integrations
- Role-based access control
- Advanced analytics and reporting

## License

Proprietary - Revoke Inc.


Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
