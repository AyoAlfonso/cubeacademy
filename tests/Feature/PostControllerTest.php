<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Services\CategoryService;
use App\Services\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $postService;
    protected $categoryService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->postService = $this->mock(PostService::class);
        $this->categoryService = $this->mock(CategoryService::class);
    }

    public function test_store_creates_new_post()
    {
        $user = User::factory()->create();

        $category = Category::factory()->create();
        $postData = [
            'title' => 'Test Post Title',
            'content' => 'This is a test post content.',
            'category_id' => $category->id,
        ];

        //Mock authenticated user
        Auth::login($user);

        // Authenticated user is set as the author of the post
        $postData = array_merge($postData, ['author_id' => $user->id]);

        $createdPost = new Post($postData);
        $createdPost->id = 1;

        $this->postService->shouldReceive('createPost')
            ->once()
            ->with($postData)
            ->andReturn($createdPost);

        // Send POST request to create a new post
        $response = $this->postJson('/api/posts', $postData);

        // Assert the response
        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'content',
                    'status',
                    'author',
                    'category',
                ],
                'message',
            ])
            ->assertJson([
                'data' => [
                    'id' => 1,
                    'title' => $postData['title'],
                    'content' => $postData['content'],
                    'status' => 'draft',
                    'author' => array(
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ),
                    'category' => $category->name,
                ],
                'message' => 'Post created successfully',
            ]);
    }
}
