<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use App\Traits\ApiResponser;

/**
 * @OA\Info(
 *    title="Cubeacademy API",
 *    version="1.0.2",
 * )
 */
class PostController extends Controller
{
    use ApiResponser;

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Get all posts",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Post")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $posts = $this->postService->getAllPosts();
            return $this->successResponse(PostResource::collection($posts), 'Posts retrieved successfully');
        } catch (\Exception $e) {
            CustomException::handle($e);
        }
    }

    public function store(StorePostRequest $request)
    {
        try {
            $user = auth()->user();
            $data = array_merge($request->validated(), ['author_id' => $user->id]);
            $post = $this->postService->createPost($data);
            return $this->successResponse(new PostResource($post), 'Post created successfully', 201);
        } catch (\Exception $e) {
            CustomException::handle($e);
        }
    }

    public function show($id)
    {
        try {
            $post = $this->postService->getPostById($id);
            return $this->successResponse(new PostResource($post), 'Post retrieved successfully');
        } catch (\Exception $e) {
            CustomException::handle($e);

        }
    }

    public function update(UpdatePostRequest $request, $id)
    {

        try {

            $post = $this->postService->updatePost($id, $request->validated());
            return $this->successResponse(new PostResource($post), 'Post updated successfully');
        } catch (\Exception $e) {
            CustomException::handle($e);
        }
    }

    public function destroy($id)
    {
        try {
            $this->postService->deletePost($id);
            return $this->successResponse(null, 'Post deleted successfully');
        } catch (\Exception $e) {
            CustomException::handle($e);
        }
    }
}
