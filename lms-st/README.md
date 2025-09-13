# EduLearn LMS

A modern Learning Management System built with PHP, featuring a responsive design and interactive dashboard.

## Features

### Authentication System
- **Login Page** (`login.php`) - User authentication with email/password
- **Registration Page** (`register.php`) - Multi-step registration form
- **Dashboard** (`dashboard.php`) - Protected user dashboard with session management
- **Logout** (`logout.php`) - Session termination and redirect

### Navigation
- **Dynamic Navbar** - Shows different buttons based on authentication status:
  - **Not Logged In**: Login and Register buttons
  - **Logged In**: Welcome message, Logout, and Dashboard buttons
- **Responsive Design** - Works on desktop and mobile devices
- **Two Navbar Styles**:
  - Regular navbar (`components/navbar.php`)
  - Tailwind navbar (`components/tw-navbar.php`)

### Pages
- **Home** (`index.php`) - Landing page with hero section, features, courses, and testimonials
- **Dashboard** (`dashboard.php`) - User dashboard with metrics, classes, and performance tracking
- **Registration** (`register.php`) - Multi-step registration form for new users

## Getting Started

1. **Start the development server**:
   ```bash
   php -S localhost:8000
   ```

2. **Access the application**:
   - Home page: `http://localhost:8000`
   - Login: `http://localhost:8000/login.php`
   - Register: `http://localhost:8000/register.php`
   - Dashboard: `http://localhost:8000/dashboard.php` (requires login)

## Authentication

### Demo Login
For testing purposes, you can use any valid email address and password to log in. The system will:
- Accept any valid email format
- Accept any password
- Create a session with the email prefix as the username

### Session Management
- Sessions are automatically managed
- Users are redirected to login if not authenticated
- Dashboard shows personalized welcome message
- Logout clears session and redirects to home

## File Structure

```
lms-st/
├── components/
│   ├── navbar.php          # Regular navbar component
│   └── tw-navbar.php       # Tailwind navbar component
├── assets/
│   ├── css/
│   │   ├── styles.css      # Main styles
│   │   └── dashboard.css   # Dashboard-specific styles
│   └── js/
│       ├── main.js         # Main JavaScript
│       ├── dashboard.js    # Dashboard functionality
│       └── navbar-theme.js # Navbar theme controller
├── index.php               # Home page
├── login.php              # Login page
├── logout.php             # Logout handler
├── register.php           # Registration page
├── dashboard.php          # User dashboard
├── config.php             # Site configuration
└── classes.php            # Classes management
```

## Technologies Used

- **PHP** - Server-side logic and session management
- **HTML5** - Semantic markup
- **CSS3** - Styling with custom properties and modern features
- **JavaScript** - Interactive functionality
- **Font Awesome** - Icons
- **Tailwind CSS** - Utility-first CSS framework (optional navbar)
- **Chart.js** - Dashboard charts and graphs

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- Mobile responsive design
- Progressive enhancement

## Development Notes

- The authentication system is simplified for demo purposes
- In production, implement proper password hashing and database storage
- Add CSRF protection for forms
- Implement proper user management and roles

