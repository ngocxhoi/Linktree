<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FileServices;
use Illuminate\Http\Request;

class UserImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['image' => 'required|mimes:png,jpg,jpeg']);

        try {
            $user = User::findOrFail(auth()->user()->id);
            $user = (new FileServices)->updateImage($user, $request);
            $user->save();

            return response()->json([
                'image' => url('/') . $user->image,
                'message' => 'Image updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
