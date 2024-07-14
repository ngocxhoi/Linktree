<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        try {
            return response()->json([
                // 'users' => UserResource::collection($users),
                'user' => Auth::user()
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], 400);
        }
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            $data = $request->validated();

            $user->name = $data['name'];
            $user->bio = $data['bio'];

            $user->save();

            return response()->json([
                'message' => 'User updated successfully',
                'user' => new UserResource($user),
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage(),
            ], 400);
        }
    }
}
