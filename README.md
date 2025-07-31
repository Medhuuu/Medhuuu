# CineLog - Your Movie Journal

A comprehensive movie tracking and review system built with PHP, MySQL, HTML, CSS, and Bootstrap. CineLog allows users to track movies they've watched, plan movies to watch, rate and review films, and manage their personal movie database.

## 🎬 Features

- **User Authentication**: Secure login and registration system
- **Movie Management**: Add, view, edit, and delete movies
- **Rating System**: Rate movies on a scale of 1-10
- **Reviews**: Write detailed reviews for movies
- **Watchlist**: Keep track of movies you want to watch
- **Personal Dashboard**: View your movie statistics and recent activity
- **Search & Filter**: Find movies by title, genre, mood, and rating
- **Sorting**: Sort movies alphabetically or by rating
- **Responsive Design**: Works perfectly on desktop, tablet, and mobile devices
- **Beautiful UI**: Modern dark theme with smooth animations

## 🛠️ Technologies Used

- **Backend**: Raw PHP (No frameworks)
- **Database**: MySQL (Relational Database)
- **Frontend**: HTML5, CSS3, Bootstrap 5
- **Icons**: Font Awesome
- **Fonts**: Google Fonts (Poppins)
- **JavaScript**: Vanilla JS for interactions

## 📋 Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Modern web browser

## 🚀 Installation

### 1. Clone or Download the Project
```bash
git clone <repository-url>
# or download and extract the ZIP file
```

### 2. Database Setup

1. Create a MySQL database named `CineLog`
2. Import the database structure:
```bash
mysql -u your_username -p CineLog < database.sql
```
3. Import sample data (optional):
```bash
mysql -u your_username -p CineLog < sample_data.sql
```

### 3. Configuration

1. Edit `config/database.php` and update the database credentials:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'CineLog');
```

### 4. Fix Sample User Passwords

Run this script to properly hash the sample user passwords:
```bash
php fix_sample_passwords.php
```

### 5. Web Server Setup

- For Apache: Place the project in your `htdocs` or `www` directory
- For Nginx: Configure your document root to point to the project directory
- Ensure your web server has permission to read the files

### 6. Access the Application

Open your web browser and navigate to:
```
http://localhost/cinelog
```

## 👤 Demo Accounts

After running the password fix script, you can use these demo accounts:

| Username | Email | Password |
|----------|-------|----------|
| moviebuff | moviebuff@example.com | password |
| cinephile | cinephile@example.com | password |
| filmcritic | filmcritic@example.com | password |

## 📁 Project Structure

```
cinelog/
├── assets/
│   ├── css/
│   │   └── style.css          # Custom CSS styles
│   ├── js/
│   │   └── main.js            # JavaScript functionality
│   └── images/                # Image assets
├── config/
│   └── database.php           # Database configuration
├── includes/
│   ├── header.php             # Header component
│   └── footer.php             # Footer component
├── pages/
│   ├── login.php              # Login page
│   ├── logout.php             # Logout functionality
│   ├── dashboard.php          # User dashboard
│   └── (other pages...)       # Additional pages
├── database.sql               # Database structure
├── sample_data.sql            # Sample data
├── fix_sample_passwords.php   # Password fixing script
├── index.php                  # Homepage
└── README.md                  # This file
```

## 🎯 Database Schema

The application uses the following main tables:

- **User**: User accounts and authentication
- **Movies**: Movie information and metadata
- **Reviews**: User reviews for movies
- **Rating**: User ratings for movies
- **Wishlist**: Movies users want to watch
- **User_Movies**: Tracking watched status
- **Genre, Moods, Language, Actors**: Movie categorization
- **Junction Tables**: Many-to-many relationships

## 🔧 Key Features Explained

### Authentication System
- Secure password hashing using PHP's `password_hash()`
- Session management for user login state
- Login with username or email

### Movie Management
- Full CRUD operations for movies
- Movie posters from external URLs
- Genre and mood categorization
- Actor associations

### Rating & Review System
- 1-10 rating scale
- Text reviews with timestamps
- Average rating calculation

### Search & Filter
- Search by movie title
- Filter by genre, mood, and watched status
- Sort alphabetically or by rating

### Responsive Design
- Mobile-first approach
- Bootstrap 5 for responsive grid
- Custom CSS for movie theme
- Dark theme optimized for movie viewing

## 🎨 Customization

### Changing Colors
Edit the CSS variables in `assets/css/style.css`:
```css
:root {
    --primary-color: #e50914;    /* Netflix red */
    --secondary-color: #221f1f;  /* Dark gray */
    --accent-color: #f5c518;     /* IMDb yellow */
    /* ... other colors */
}
```

### Adding New Features
- Follow the existing file structure
- Use the Database class for database operations
- Include proper session management
- Maintain responsive design principles

## 🔒 Security Features

- Password hashing with `password_hash()`
- SQL injection prevention with prepared statements
- XSS protection with `htmlspecialchars()`
- Session-based authentication
- Input validation and sanitization

## 🚦 Common Issues & Solutions

### Database Connection Issues
- Check your MySQL credentials in `config/database.php`
- Ensure MySQL service is running
- Verify database name exists

### Permission Issues
- Ensure web server has read permissions on all files
- Check file ownership and permissions

### Sample Data Not Loading
- Run `fix_sample_passwords.php` after importing sample data
- Check MySQL error logs for import issues

## 🎬 Future Enhancements

- **Social Features**: Follow other users, public reviews
- **Movie API Integration**: Automatic movie data fetching
- **Advanced Recommendations**: ML-based movie suggestions
- **Mobile App**: Native mobile application
- **Export Features**: Export watchlists and reviews
- **Two-Factor Authentication**: Enhanced security
- **Email Notifications**: Review reminders and updates

## 📝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

This project is created for educational purposes as part of the 311L DBMS Course.

## 🎯 Course Project Details

**Project**: CineLog: A Movie Review Tracker  
**Course**: 311L Database Management Systems  
**Technologies**: PHP, MySQL, HTML, CSS, Bootstrap  
**Features**: Complete CRUD operations, user authentication, responsive design

---

**Made with ❤️ for movie enthusiasts**