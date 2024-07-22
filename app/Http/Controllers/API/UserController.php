<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest; 
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Traits\ApiResponser;

class UserController extends Controller
{
    use ApiResponser;

    protected $userService;
    public function __construct(UserService $userService)       
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return $this->successResponse(UserResource::collection($users), 'Users retrieved successfully');
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());
        return $this->successResponse(new UserResource($user), 'User created successfully', 201);
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        return $this->successResponse(new UserResource($user), 'User retrieved successfully');
    }

    public function update(StoreUserRequest $request, $id)
    {
        $user = $this->userService->updateUser($id, $request->validated());
        return $this->successResponse(new UserResource($user), 'User updated successfully');
    }

    public function destroy($id)
    {
            $this->userService->deleteUser($id);
        return $this->successResponse(null, 'User deleted successfully');
    }
}