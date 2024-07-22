<?php

namespace App\Repositories;
use App\Models\Category;

class CategoryRepository
{
    public function all()
    {
        return Category::all();
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function findOrFail($id)
    {
        return Category::findOrFail($id);
    }

    public function update($id, array $data)
    {
        $category = $this->findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        $category = $this->findOrFail($id);
        return $category->delete();
    }
}