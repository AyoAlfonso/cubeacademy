<?php

namespace App\Services;

use App\Repositories\CommentRepository;

class CommentService
{
    protected $commentRepository;
    public function __construct(CommentRepository $commentRepository)       
    {
        $this->commentRepository = $commentRepository;
    }

    public function getAllComments()
    {
        return $this->commentRepository->all();
    }

    public function createComment($data)
    {            
        return $this->commentRepository->create($data);
    }

    public function getCommentById($id)
    {
        return $this->commentRepository->findOrFail($id);
    }

    public function updateComment($id, $data)
    {
        return $this->commentRepository->update($id, $data);
    }

    public function deleteComment($id)
    {
        return $this->commentRepository->delete($id);
    }
}