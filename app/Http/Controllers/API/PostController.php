<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use App\Traits\ApiResponser;

class PostController extends Controller
{
    use ApiResponser;

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $posts = $this->postService->getAllPosts();
        return $this->successResponse(PostResource::collection($posts), 'Posts retrieved successfully');
    }

    public function store(StorePostRequest $request)
    {
        $post = $this->postService->createPost($request->validated());
        return $this->successResponse(new PostResource($post), 'Post created successfully', 201);
    }

    public function show($id)
    {
        $post = $this->postService->getPostById($id);
        return $this->successResponse(new PostResource($post), 'Post retrieved successfully');
    }

    public function update(UpdatePostRequest $request, $id)
    {
        $post = $this->postService->updatePost($id, $request->validated());
        return $this->successResponse(new PostResource($post), 'Post updated successfully');
    }

    public function destroy($id)
    {
        $this->postService->deletePost($id);
        return $this->successResponse(null, 'Post deleted successfully');
    }
}