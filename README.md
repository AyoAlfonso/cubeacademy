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
3. Copy `.env.example` to `.env` and cd into the `database` folder and run `touch database/database.sqlite` to create an empty sqlite database
4. Run `php artisan key:generate` and you will get a new key in your `.env` file
5. Run `php artisan migrate`
6. Run `php artisan db:seed` to seed the database with 20 users and their posts and over 300 comments
7. Run `php artisan serve` to start the development server at `http://127.0.0.1:8000/api` e.g for all the posts `http://127.0.0.1:8000/api/posts`
8. To Run `php artisan app:publish-scheduled` to run the scheduled jobs that every minute directly. Check the `app/Console/Commands/PublishScheduledPosts.php` file for how it works
9. Run `php artisan l5-swagger:generate` to generate the swagger documentation at `public/swagger.json` and 127.0.0.1:8000/api/documentation

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
-   Followed PSR-12 coding standards

## Testing

Run `php artisan test` to execute the unit and feature tests.


```bash
Scheduler is implemented here `app/Console/Commands/PublishScheduledPosts.php`
Create a couple blogposts with the `scheduled_at` into the future maybe 2 mins into the future.

Run the command using `php artisan app:publish-scheduled-posts` to run the job directly. 

To start the Scheduler

You can use  `php artisan schedule:work` and laravel will mimic a scheduler

For the real thing you need to set up a cron job on you machine.

Go to your terminal, cd into your project and run:
crontab -e

after that press i in your keyboard in order to insert data, then paste the command below:

* * * * * php /path-to-project schedule:run 1>> /dev/null 2>&1
after that press the ESC button and write :wq (if you want to save the changes)
NB: To get full path of your project, you can run the 'pwd' command.
```



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

## API Endpoints

-   Authentication:

    -   POST /api/register
    -   POST /api/login

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
