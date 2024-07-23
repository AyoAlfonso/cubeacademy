<?php

namespace App\Http\Controllers\API;

use App\Exceptions\CustomException;
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
        try {
            $users = $this->userService->getAllUsers();
            return $this->successResponse(UserResource::collection($users), 'Users retrieved successfully');
        } catch (\Exception $e) {
            CustomException::handle($e);
        }
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $user = $this->userService->createUser($request->validated());
            return $this->successResponse(new UserResource($user), 'User created successfully', 201);
        } catch (\Exception $e) {
            CustomException::handle($e);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->userService->getUserById($id);
            return $this->successResponse(new UserResource($user), 'User retrieved successfully');
        } catch (\Exception $e) {
            CustomException::handle($e);
        }
    }

    public function update(StoreUserRequest $request, $id)
    {
        try {
            $user = $this->userService->updateUser($id, $request->validated());
            return $this->successResponse(new UserResource($user), 'User updated successfully');
        } catch (\Exception $e) {
            CustomException::handle($e);
        }
    }

    public function destroy($id)
    {
        try {
            $this->userService->deleteUser($id);
            return $this->successResponse(null, 'User deleted successfully');
        } catch (\Exception $e) {
            CustomException::handle($e);
        }
    }
}
