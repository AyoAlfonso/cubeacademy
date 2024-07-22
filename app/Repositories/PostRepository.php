<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository
{
    public function all()
    {
        return Post::all();
    }

    public function create(array $data)
    {
        return Post::create($data);
    }

    public function findOrFail($id)
    {
        return Post::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $post = $this->findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete($id)
    {
        $post = $this->findOrFail($id);
        return $post->delete();
    }
}