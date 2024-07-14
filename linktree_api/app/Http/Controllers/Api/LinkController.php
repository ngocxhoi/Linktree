<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinkRequest;
use App\Http\Resources\LinkResource;
use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LinkController extends Controller
{
    public function index()
    {
        try {
            $links = Link::where('user_id', auth()->user()->id)->get();
            return response()->json([
                'links' => LinkResource::collection($links)
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LinkRequest $request)
    {
        $data = $request->validated();

        try {
            $data['user_id'] = Auth::id();
            $data['image'] = '/link-placeholder.png';

            $link = Link::create($data);

            return response()->json([
                'link' => new LinkResource($link),
                'message' => 'Link created',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LinkRequest $request, Link $link)
    {
        $data = $request->validated();

        try {
            $link->name = $data['name'];
            $link->url = $data['url'];
            $link->save();

            return response()->json([
                'link' => new LinkResource($link),
                'message' => 'Link updated'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        try {
            if (
                !is_null($link->image)
                && file_exists(public_path() . $link->image)
                && $link->image != '/user-placeholder.png'
                && $link->image != '/link-placeholder.png'

            ) {
                unlink(public_path() . $link->image);
            }
            $link->delete();

            return response()->json([
                'message' => 'Link deleted'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 400);
        }
    }
}
