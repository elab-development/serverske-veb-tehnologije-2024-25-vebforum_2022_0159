# Forum API

REST API za forum razvijen u okviru seminarskog rada iz predmeta Serverske veb tehnologije.

## Tehnologije

- PHP 8.x
- Laravel 12
- Laravel Sanctum
- SQLite
- REST API
- Eloquent ORM

## Funkcionalnosti

### Authentication

- Register
- Login
- Logout

### Topics

- Create topic
- Get all topics
- Get topic
- Update topic
- Delete topic
- Search
- Filter
- Sort
- Pagination

### Posts

- CRUD operations
- Get posts by topic

### Comments

- CRUD operations
- Get comments by post

### Likes

- Toggle like
- Get post likes

### Attachments

- Upload attachment
- Get attachment
- Delete attachment

### User Roles

- User
- Moderator
- Admin

### Admin

- Get all users
- Update user role
- Delete user
- System statistics

## External REST APIs

- Abstract Email Reputation API
- PurgoMalum Profanity API

## Installation

Clone repository

```bash
git clone <repository-url>
```

Install dependencies

```bash
composer install
```

Copy environment

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Run migrations and seeders

```bash
php artisan migrate:fresh --seed
```

Create storage link

```bash
php artisan storage:link
```

Start application

```bash
php artisan serve
```

## Test Users

### Admin

Email

```
admin@forum.test
```

Password

```
password123
```

### Moderator

Email

```
moderator@forum.test
```

Password

```
password123
```

### User

Email

```
marko@forum.test
```

Password

```
password123
```

## API Features

- Authentication with Laravel Sanctum
- Role based authorization
- Nested REST routes
- File upload support
- Search
- Filtering
- Sorting
- Pagination
- Admin statistics
- Email reputation validation
- Profanity detection

## Database

Tables

- users
- topics
- posts
- comments
- likes
- attachments
- personal_access_tokens
- sessions
- password_reset_tokens

## License

Educational project.