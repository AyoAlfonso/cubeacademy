<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function all()
    {
        return User::all();
    }

    public function find(int $id): User
    {
        return User::find($id);
    }
    public function findOrFail($id)
    {
        return User::findOrFail($id);
    }

    public function findByEmail(string $email): User
    {
        return User::where('email', $email)->first();
    }

    public function findByName(string $name): User
    {
        return User::where('name', $name)->first();
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user): User
    {
        $user->delete();
        return $user;
    }
}
