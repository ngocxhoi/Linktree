<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Services\FileServices;
use Illuminate\Http\Request;

class LinkImageController extends Controller
{
    public function store(Request $request, Link $link)
    {
        $request->validate(['image' => 'required|mimes:png,jpg,jpeg', 'id' => 'required']);

        try {
            $link = (new FileServices)->updateImage($link, $request);
            $link->save();

            return response()->json([
                'image' => url('/') . $link->image,
                'message' => 'Image updated successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
