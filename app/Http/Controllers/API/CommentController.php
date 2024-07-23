<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;
use App\Traits\ApiResponser;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        try {
            $comments = $this->commentService->getAllComments();
            return $this->successResponse(CommentResource::collection($comments), 'Comments retrieved successfully');
        } catch (\Exception $e) {
            throw CustomException::serverError($e->getMessage());
        }
    }

    public function store(StoreCommentRequest $request)
    {
        try {
            $comment = $this->commentService->createComment($request->validated());
            return $this->successResponse(new CommentResource($comment), 'Comment created successfully', 201);
        } catch (\Exception $e) {
            throw CustomException::serverError($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $comment = $this->commentService->getCommentById($id);
            return $this->successResponse(new CommentResource($comment), 'Comment retrieved successfully');
        } catch (ModelNotFoundException $e) {
            throw CustomException::notFound('Category not found');
        } catch (\Exception $e) {
            throw CustomException::serverError($e->getMessage());
        }
    }

    public function update(StoreCommentRequest $request, $id)
    {
        try {
            $category = $this->commentService->updateComment($id, $request->validated());
            return $this->successResponse(new CommentService($category), 'Comment updated successfully');
        } catch (ModelNotFoundException $e) {
            throw CustomException::notFound('Comment not found');
        } catch (\Exception $e) {
            throw CustomException::serverError($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->commentService->deleteComment($id);
            return $this->successResponse(null, 'Comment deleted successfully');
        } catch (ModelNotFoundException $e) {
            throw CustomException::notFound('Comment not found');
        } catch (\Exception $e) {
            throw CustomException::serverError($e->getMessage());
        }
    }
}
