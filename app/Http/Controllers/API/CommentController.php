<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Services\CommentService;
use App\Traits\ApiResponser;

class CommentController extends Controller
{
    use ApiResponser;

    protected $commentService;
    public function __construct(CommentService $commentService)       
    {
        $this->commentService = $commentService;
    }

    public function index()
    {
        $comments = Comment::all();
        return $this->successResponse(CommentResource::collection($comments), 'Comments retrieved successfully');
    }

    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create($request->validated());
        return $this->successResponse(new CommentResource($comment), 'Comment created successfully', 201);
    }

    public function show(Comment $comment)
    {
        return $this->successResponse(new CommentResource($comment), 'Comment retrieved successfully');
    }

    public function update(StoreCommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());
        return $this->successResponse(new CommentResource($comment), 'Comment updated successfully');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return $this->successResponse(null, 'Comment deleted successfully');
    }
}