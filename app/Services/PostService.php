<?php

namespace App\Services;

use App\Repositories\PostRepository;

class PostService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAllPosts()
    {
        return $this->postRepository->all();
    }

    public function createPost(array $data)
    {
        return $this->postRepository->create($data);
    }

    public function getPostById($id)
    {
        return $this->postRepository->findOrFail($id);
    }

    public function updatePost($id, array $data)
    {
        return $this->postRepository->update($id, $data);
    }

    public function deletePost($id)
    {
        return $this->postRepository->delete($id);
    }
}