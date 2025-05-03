# E-Voting System

A secure and user-friendly electronic voting system built with Laravel, featuring real-time results and glass morphism UI design.

## Features

- 🔐 Secure Authentication System
- 👥 User & Admin Roles
- 🗳️ Real-time Vote Tracking
- 📊 Live Result Updates
- 📱 Responsive Glass Morphism Design
- 👨‍💼 Candidate Management
- 📈 Voting Statistics

## Tech Stack

- **Framework:** Laravel 10.x
- **Database:** MySQL
- **Frontend:** 
  - Bootstrap 5
  - Chart.js
  - Font Awesome
  - Custom Glass Morphism CSS

## Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/e-voting.git
cd e-voting
```

2. Install PHP dependencies:
```bash
composer install
```

3. Copy environment file:
```bash
copy .env.example .env
```

4. Configure your database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=evoting
DB_USERNAME=root
DB_PASSWORD=
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Run migrations and seeders:
```bash
php artisan migrate --seed
```

7. Create storage link:
```bash
php artisan storage:link
```

8. Start the development server:
```bash
php artisan serve
```

## Directory Structure

```
E-Voting/
├── app/
│   ├── Http/Controllers/   # Controllers
│   ├── Models/            # Database models
├── database/
│   ├── migrations/       # Database migrations
│   └── seeders/         # Database seeders
├── public/              # Public assets
├── resources/
│   ├── views/           # Blade templates
│   └── css/            # Stylesheets
└── routes/              # Application routes
```

## User Roles

### Admin
- Manage candidates
- View voting statistics
- Monitor real-time results
- Manage users

### Voter
- Cast vote
- View election results
- Update profile

## Screenshots

[Add screenshots of your application here]

## Security

- CSRF Protection
- SQL Injection Prevention
- XSS Protection
- Session Security
- Role-based Access Control

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Author

Your Name
- GitHub: [@yourusername](https://github.com/yourusername)
- Email: your.email@example.com

## Acknowledgments

- Laravel Team
- Bootstrap Team
- Chart.js Contributors
