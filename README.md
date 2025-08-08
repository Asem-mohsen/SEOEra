# Laravel Posts Task

A complete Laravel application for managing posts with user authentication, admin panel, and RESTful APIs.

## Features

- ✅ **Laravel Telescope** - Logging all actions and errors
- ✅ **JWT Authentication** - Secure API authentication
- ✅ **User Registration** - Register with name, email, phone, and password
- ✅ **Mobile Login** - Login with phone number and password
- ✅ **Posts API** - CRUD operations for posts
- ✅ **Admin Panel** - Dashboard for managing users and posts
- ✅ **Post Creation** - Create posts with title, description (2KB limit), and contact phone
- ✅ **Paginated Posts List** - View posts with truncated descriptions (512 chars)
- ✅ **Database Migrations & Seeders** - Proper database setup
- ✅ **SOLID Principles** - Clean architecture with services and repositories
- ✅ **Unit Testing** - API test coverage
- ✅ **Custom Artisan Command** - `php artisan install:project`
- ✅ **Daily Reports** - Automated daily reports via email

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd laravel-posts-task
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Set up environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database in `.env`**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_posts
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Install the project**
   ```bash
   php artisan install:project "Laravel Posts Task"
   ```

## API Documentation

### Authentication Endpoints

#### Register User
```http
POST /api/v1/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "phone": "+1234567890",
    "password": "password123",
    "password_confirmation": "password123"
}
```

#### Login with Mobile
```http
POST /api/v1/login
Content-Type: application/json

{
    "phone": "+1234567890",
    "password": "password123"
}
```

#### Get Current User
```http
GET /api/v1/me
Authorization: Bearer {token}
```

#### Logout
```http
POST /api/v1/logout
Authorization: Bearer {token}
```

### Posts Endpoints

#### Get All Posts (Public)
```http
GET /api/v1/posts?per_page=15
```

#### Get Single Post (Public)
```http
GET /api/v1/posts/{id}
```

#### Create Post (Authenticated)
```http
POST /api/v1/posts
Authorization: Bearer {token}
Content-Type: application/json

{
    "title": "My Post Title",
    "description": "This is my post description (max 2KB)",
    "contact_phone": "+1234567890"
}
```

#### Get User's Posts (Authenticated)
```http
GET /api/v1/my-posts?per_page=15
Authorization: Bearer {token}
```

### Admin Endpoints

#### Dashboard Statistics
```http
GET /api/v1/admin/stats
```

#### Get All Users
```http
GET /api/v1/users?per_page=15
```

#### Get Single User
```http
GET /api/v1/users/{id}
```

#### Update User
```http
PUT /api/v1/users/{id}
Content-Type: application/json

{
    "name": "Updated Name",
    "email": "updated@example.com",
    "phone": "+1234567890"
}
```

#### Delete User
```http
DELETE /api/v1/users/{id}
```

#### Get All Posts
```http
GET /api/v1/posts?per_page=15
```

#### Get Single Post
```http
GET /api/v1/posts/{id}
```

#### Update Post
```http
PUT /api/v1/posts/{id}
Content-Type: application/json

{
    "title": "Updated Title",
    "description": "Updated description",
    "contact_phone": "+1234567890"
}
```

#### Delete Post
```http
DELETE /api/v1/posts/{id}
```

## Admin Panel

Access the admin panel at: `http://localhost:8000/admin`

The admin panel provides:
- Dashboard with statistics
- User management (CRUD)
- Post management (CRUD)
- Real-time data updates

## Testing

Run the test suite:
```bash
php artisan test
```

## Daily Reports

The system includes a daily report command that runs at midnight:
```bash
php artisan report:daily
```

This command:
- Counts new users and posts for the day
- Sends email report to admin
- Can be scheduled with cron

## Database Structure

### Users Table
- `id` - Primary key
- `name` - User's name
- `email` - Unique email address
- `phone` - Unique phone number
- `password` - Hashed password
- `created_at` - Creation timestamp
- `updated_at` - Update timestamp

### Posts Table
- `id` - Primary key
- `user_id` - Foreign key to users
- `title` - Post title (max 255 chars)
- `description` - Post description (max 2KB)
- `contact_phone` - Contact phone number
- `created_at` - Creation timestamp
- `updated_at` - Update timestamp

## Architecture

The application follows SOLID principles and clean architecture:

- **Controllers** - Handle HTTP requests and responses
- **Services** - Business logic layer
- **Repositories** - Data access layer
- **Models** - Eloquent models with relationships
- **Resources** - API response formatting
- **Requests** - Form validation
- **Commands** - Artisan commands for automation

## Telescope

Laravel Telescope is configured to log:
- All HTTP requests
- Database queries
- Cache operations
- Job executions
- Mail sending
- Notifications
- Scheduled tasks

Access Telescope at: `http://localhost:8000/telescope`

## Security Features

- JWT token authentication
- Password hashing
- Input validation
- SQL injection protection
- XSS protection
- CSRF protection

## Performance Optimizations

- Database indexing
- Eager loading for relationships
- Pagination for large datasets
- Query optimization
- Caching strategies

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
