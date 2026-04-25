# FotoKita - Photo Management System

A modern Laravel 12 application for photo management with user authentication, admin panel, and responsive design.

## Features

- 🔐 User Authentication (Login/Register)
- 📸 Photo Upload & Management
- 👨‍💼 Admin Panel for User Management
- 📊 Dashboard with Statistics
- 🎨 Modern UI with Tailwind CSS
- 📱 Responsive Design
- 🌙 Dark Theme Support
- 📋 Activity Logging

## Tech Stack

- **Backend**: Laravel 12 (PHP 8+)
- **Frontend**: Tailwind CSS, Bootstrap Icons
- **Database**: SQLite (for Vercel deployment)
- **Build Tool**: Vite
- **Deployment**: Vercel

## Local Development

### Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js & npm
- MySQL or SQLite

### Installation

1. Clone the repository:
```bash
git clone <your-repo-url>
cd foto-kita
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node dependencies:
```bash
npm install
```

4. Copy environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Run migrations:
```bash
php artisan migrate
```

7. Seed the database:
```bash
php artisan db:seed
```

8. Build assets:
```bash
npm run build
```

9. Start the development server:
```bash
php artisan serve
```

10. Start Vite for asset compilation:
```bash
npm run dev
```

Visit `http://localhost:8000` to view the application.

## Vercel Deployment

### Prerequisites

- Vercel account
- GitHub repository

### Deployment Steps

1. **Push to GitHub**:
   - Create a new repository on GitHub
   - Push your code to the repository

2. **Connect to Vercel**:
   - Go to [vercel.com](https://vercel.com)
   - Click "New Project"
   - Import your GitHub repository

3. **Configure Environment Variables**:
   In Vercel dashboard, go to Project Settings > Environment Variables and add:

   ```
   APP_NAME=FotoKita
   APP_ENV=production
   APP_KEY=<generate-a-new-key>
   APP_DEBUG=false
   APP_URL=https://your-app-name.vercel.app
   ```

   To generate APP_KEY, run locally:
   ```bash
   php artisan key:generate --show
   ```

4. **Deploy**:
   - Vercel will automatically detect the configuration and deploy
   - The build process will run database migrations and seed data
   - Your app will be available at `https://your-app-name.vercel.app`

### Database Setup

The application uses SQLite for Vercel deployment. The database is created automatically during the build process in `/tmp/database.sqlite`.

## Project Structure

```
├── app/
│   ├── Http/Controllers/     # Controllers
│   └── Models/              # Eloquent Models
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── public/                  # Public assets
├── resources/
│   ├── css/                # Stylesheets
│   ├── js/                 # JavaScript files
│   └── views/              # Blade templates
├── routes/
│   └── web.php             # Web routes
├── api/                    # Vercel serverless functions
└── vercel.json             # Vercel configuration
```

## Default Credentials

After seeding the database, you can login with:

- **Admin User**: admin@fotokita.com / password
- **Regular User**: user@fotokita.com / password

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
