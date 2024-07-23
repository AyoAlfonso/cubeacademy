# Blog Post API

A laravel RESTful API for a blog post system. I am using token based authentication because we are using an SPA in the frontend.

## Features and Technical Decisions

-   `C|R|U|D` operations for blog posts, users blog categories, and blog comments. With Factory fake data generation for seeding the database
-   Using `Route::apiResource()` in the routes to keep API cleaner and more organized
-   Used Form requests for input validation
-   A Service layer for business logic (see `Services` folder)
-   Repository pattern for data access (see `Repositories` folder)
-   Custom exception handling (see `Exceptions` folder)
-   Used API response trait for consistent API responses see `ApiResponser` trait in `Traits` folder
-   Validation Custom Error handling with the failedValidation method using `ValidationException` in the `StoreCategoryRequest`, `StoreCommentRequest`, `StorePostRequest`, `StoreUserRequest`
-   Controller Custom error handling with `CustomException` class

## Setup

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure your database there is an empty sqlite database in the `database/` folder of the project
4. Run `php artisan key:generate` and you will get a new key in your `.env` file
5. Run `php artisan migrate`
6. Run `php artisan serve` to start the development server
7. Run `php artisan db:seed` to seed the database with 20 users and their posts and over 300 comments
8. To Run `php artisan app:publish-scheduled` to run the scheduled jobs that every minute directly. Check the `app/Console/Commands/PublishScheduledPosts.php` file for how it works
9. Run `php artisan l5-swagger:generate` to generate the swagger documentation at `public/swagger.json` and 127.0.0.1:8000/api/documentation

## API Endpoints

-   Authentication:

    -   POST /api/register
    -   POST /api/login
    -   GET /api/logout

-   Posts:

    -   GET /api/posts
    -   POST /api/posts
    -   GET /api/posts/{id}
    -   PUT /api/posts/{id}
    -   DELETE /api/posts/{id}

-   Categories:

    -   GET /api/categories
    -   POST /api/categories
    -   GET /api/categories/{id}
    -   PUT /api/categories/{id}
    -   DELETE /api/categories/{id}

-   Comments:

    -   GET /api/comments
    -   POST /api/comments
    -   GET /api/comments/{id}
    -   PUT /api/comments/{id}
    -   DELETE /api/comments/{id}

-   Users:
    -   GET /api/users
    -   POST /api/users
    -   GET /api/users/{id}
    -   PUT /api/users/{id}
    -   DELETE /api/users/{id}

## Architecture

The API follows a layered architecture:

1. Routes: Define API endpoints
2. Controllers: Handle HTTP requests and responses
3. Form Requests: Validate input data
4. Services: Implement business logic
5. Repositories: Handle data access and storage
6. Models: Represent database tables and relationships
7. Resources: Format API responses

This architecture promotes separation of concerns and makes the code more maintainable and testable.

## Best Practices

-   Implemented repository pattern for separation of concerns
-   Used services to encapsulate business logic
-   Used standard REST conventions for APIs
-   Used proper HTTP status codes and consistent response format using Laravel's Response Factory
-   Implemented global error handling
-   Used dependency injection for better testability see the Factory pattern in models
-   Follow PSR-12 coding standards

## Testing

Run `php artisan test` to execute the test suite.

## License

This project is open-sourced software licensed under the MIT license.

Example CLI commands you might find useful to create files and in debbuging

```bash
# General Artisan commands
php artisan serve
php artisan migrate
php artisan migrate:fresh

# Migration generation
php artisan make:migration create_categories_table
php artisan make:controller API/AuthController

# Route Checks
php artisan route:list
php artisan route:clear

# Factory generation
php artisan make:factory PostFactory --model=Post
php artisan make:factory CategoryFactory --model=Category
php artisan make:factory CommentFactory --model=Comment

#Swagger documentation generation
php artisan l5-swagger:generate

```
