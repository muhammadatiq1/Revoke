# Revoke - Quick Reference Guide

## Getting Started (5 Minutes)

```bash
cd revoke
composer install && npm install
php artisan migrate:fresh --seed
npm run build
php artisan serve
# Visit http://localhost:8000/dashboard
```

## Application URLs

| Route | Purpose |
|-------|---------|
| `/dashboard` | Main dashboard with metrics |
| `/employees` | List all employees |
| `/employees/{id}` | Employee details & software |
| `/softwares` | List all applications |
| `/softwares/{id}` | Software details & users |
| `/offboarding` | All offboarding tasks |
| `/offboarding/{employee}` | Employee's kill list |

## Key Features at a Glance

### Dashboard
- **Total Monthly Spend**: $694.99 (from sample data)
- **Pending Tasks**: Shows count in red badge
- **Active Employees**: 18 of 20
- **Recent Activity**: Last 5 offboarding tasks

### Employees
- View all 20 sample employees
- See software assignments (3-5 per employee)
- Click to see full details with costs
- "Offboard" button to initiate process

### Applications
- 10 sample softwares (Slack, Jira, Zoom, etc.)
- Monthly costs from $0 to $250
- Risk levels: Low (7) or High (3)
- View which employees use each app

### Offboarding
- 2 terminated employees pre-loaded
- See all access to revoke
- Click "Mark Revoked" to complete tasks
- View total savings from terminating employee

## Database Tables

```sql
employees (20 records)
├── id, name, email, department, status, avatar_url

softwares (10 records)
├── id, name, monthly_cost, risk_level, website_url

employee_software (80+ pivot records)
├── id, employee_id, software_id, assigned_at

offboarding_tasks (15+ records for 2 terminated employees)
├── id, employee_id, software_id, status, revoked_at
```

## Model Relationships

```php
Employee
  ->softwares() // belongsToMany
  ->offboardingTasks() // hasMany

Software
  ->employees() // belongsToMany
  ->offboardingTasks() // hasMany

OffboardingTask
  ->employee() // belongsTo
  ->software() // belongsTo
```

## Workflow Example

**Scenario**: John Smith is leaving the company

1. **Navigate to Employees** → Find "John Smith"
2. **Click "Offboard"** → Status changes to "Terminated"
3. **System creates tasks** → One task per software (e.g., 4 tasks)
4. **View Kill List** → `/offboarding/{employee}`
5. **Mark as Revoked** → Click "Revoke Access" for each app
6. **Summary Stats** → See total cost savings ($XX.XX/month)

## Key Controllers

### DashboardController
```php
->index()
  Returns: totalMonthlySpend, pendingOffboardingTasks, 
           activeEmployees, recentActivities
```

### OffboardingController
```php
->index()      // List all offboarding tasks
->show()       // Employee's kill list
->store()      // Initiate offboarding (creates tasks)
->revoke()     // Mark task as revoked
```

### EmployeeController
```php
->index()      // List all employees
->show()       // Employee details
```

### SoftwareController
```php
->index()      // List all software
->show()       // Software details with users
```

## Sample Data Included

### Softwares (10)
1. Slack - $8.50/mo (Low Risk)
2. Jira - $7.00/mo (High Risk)
3. Zoom - $15.99/mo (Low Risk)
4. Figma - $12.00/mo (Low Risk)
5. AWS - $250.00/mo (High Risk)
6. GitHub Enterprise - $21.00/mo (High Risk)
7. Microsoft 365 - $20.00/mo (Low Risk)
8. Notion - $10.00/mo (Low Risk)
9. Datadog - $100.00/mo (High Risk)
10. Stripe - $0.00/mo (High Risk)

### Employees (20)
- 18 Active, 2 Terminated
- Departments: Engineering, Sales, Marketing, HR, Finance, Operations
- Each has 3-5 software assignments
- Avatars: Randomly generated via Pravatar

### Departments
- Engineering (5-7 employees)
- Sales (3-4 employees)
- Marketing (2-3 employees)
- HR (1-2 employees)
- Finance (2-3 employees)
- Operations (3-4 employees)

## UI Components

### Navigation
- **Sidebar**: Logo, Menu Links, Dashboard/Employees/Apps/Offboarding
- **Top Bar**: Search, User Profile Dropdown
- **Notifications**: Red badge on Offboarding with count

### Cards
- Stats cards with icon and metric
- Employee cards with avatar and quick actions
- Software cards with cost and risk level

### Tables
- Responsive design, horizontal scroll on mobile
- Status badges (green/yellow/red)
- Risk indicators (color-coded)
- Action buttons (View, Offboard, Revoke)

## Development

### File Structure
```
app/
  ├── Http/Controllers/ (4 files)
  └── Models/ (3 files)

database/
  ├── migrations/ (4 files)
  └── seeders/ (3 files + DatabaseSeeder)

resources/
  ├── views/
  │   ├── layouts/ (1 file)
  │   ├── dashboard/ (1 file)
  │   ├── employees/ (2 files)
  │   ├── softwares/ (2 files)
  │   └── offboarding/ (2 files)
  ├── css/ (app.css with Tailwind)
  └── js/ (app.js with Alpine)

routes/
  └── web.php (8 routes)
```

### Running in Development

```bash
# Terminal 1: PHP Server
php artisan serve

# Terminal 2: Vite Watch
npm run dev

# Access: http://localhost:8000
```

### Building for Production

```bash
npm run build
# Creates /public/build/ with optimized assets
```

## Customization

### Change Sample Softwares
Edit `database/seeders/SoftwareSeeder.php`:
```php
$softwares = [
    ['name' => 'Your App', 'monthly_cost' => 99, ...],
];
```

### Change Departments
Edit `database/seeders/EmployeeSeeder.php`:
```php
$departments = ['Engineering', 'Sales', ...];
```

### Modify Database Schema
1. Create new migration: `php artisan make:migration`
2. Add to migration file
3. Run: `php artisan migrate`

### Add New Routes
Edit `routes/web.php`:
```php
Route::get('/path', [Controller::class, 'method'])->name('route.name');
```

## Common Tasks

### Seed Database Fresh
```bash
php artisan migrate:fresh --seed
```

### View Database
Use MySQL client:
```bash
mysql -u root -p revoke_app
SELECT * FROM employees;
```

### Check Routes
```bash
php artisan route:list
```

### Debug Models
```bash
php artisan tinker
>>> Employee::with('softwares')->first()
>>> Software::withCount('employees')->first()
```

## Troubleshooting

### Database Connection Error
- Check `.env` file DB credentials
- Ensure MySQL is running
- Run: `php artisan migrate:fresh --seed`

### Asset Not Loading
- Run: `npm run build`
- Check `/public/build/` directory exists

### Blade Syntax Error
- Check file encoding (UTF-8)
- Verify `{{ }}` syntax is correct
- Clear cache: `php artisan cache:clear`

### Route Not Found
- Run: `php artisan route:list`
- Check `routes/web.php` spelling
- Clear routes cache: `php artisan route:cache --clear`

## Performance Tips

1. Use eager loading: `->with('softwares')`
2. Limit results: `->paginate(15)`
3. Use select(): `->select('id', 'name')`
4. Cache expensive queries: `->remember(3600)`
5. Index foreign keys in database

## Security Considerations

1. **CSRF Protection**: Forms use `@csrf`
2. **SQL Injection**: Eloquent queries are parameterized
3. **XSS Prevention**: Blade `{{ }}` escapes output
4. **Rate Limiting**: Add to routes if needed
5. **Authentication**: Add Laravel Breeze/Jetstream

## Deployment Checklist

- [ ] Set `APP_ENV=production` in .env
- [ ] Set `APP_DEBUG=false` in .env
- [ ] Generate app key: `php artisan key:generate`
- [ ] Build assets: `npm run build`
- [ ] Run migrations: `php artisan migrate`
- [ ] Run seeders: `php artisan db:seed`
- [ ] Optimize: `php artisan optimize`
- [ ] Clear caches: `php artisan cache:clear`
- [ ] Set proper file permissions
- [ ] Use HTTPS
- [ ] Set up logging and monitoring

## Support & Documentation

- **Laravel Docs**: https://laravel.com/docs/11
- **Tailwind CSS**: https://tailwindcss.com/docs
- **Alpine.js**: https://alpinejs.dev/
- **Vite**: https://vitejs.dev/

## License

Proprietary - Revoke Inc. © 2026
