<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $categories = Category::factory()->count(5)->create();

        // Create 20 users who will author posts
        $postAuthors = User::factory()->count(20)->create();

        // Create posts and associate them with categories and authors
        $postAuthors->each(function ($user) use ($categories) {
            Post::factory()->count(5)->create([
                'author_id' => $user->id,
                'category_id' => $categories->random()->id,
            ]);
        });

        // Create 10 users who will only comment
        $commentAuthors = User::factory()->count(10)->create();

        // Get all posts
        $posts = Post::all();

        // Create comments for each post from the comment authors
        $posts->each(function ($post) use ($commentAuthors) {
            Comment::factory()->count(3)->create([
                'post_id' => $post->id,
                'author_id' => $commentAuthors->random()->id,
            ]);
        });
    }
}
