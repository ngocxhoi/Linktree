<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    // public function index()
    // {
    //     try {
    //         return response()->json(Theme::all(), 200);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 400);
    //     }
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate(['theme_id' => 'required']);

        try {
            $user = User::findOrFail(auth()->user()->id);
            $user->theme_id = $request->theme_id;
            $user->save();

            return response()->json([
                'theme_id' => $user->theme_id
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
