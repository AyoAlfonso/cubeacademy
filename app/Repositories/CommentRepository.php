<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    public function all()
    {
        return Comment::all();
    }

    public function create(array $data)
    {
        return Comment::create($data);
    }

    public function findOrFail($id)
    {
        return Comment::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $comment = $this->findOrFail($id);
        $comment->update($data);
        return $comment;
    }

    public function delete($id)
    {
        $comment = $this->findOrFail($id);
        return $comment->delete();
    }
}