<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request, Post $post)
    {
        $like = Like::where('user_id', $request->user()->id)
            ->where('post_id', $post->id)
            ->first();

        if ($like) {
            $like->delete();

            return response()->json([
                'message' => 'Like removed.',
                'likes_count' => $post->likes()->count(),
            ]);
        }

        Like::create([
            'user_id' => $request->user()->id,
            'post_id' => $post->id,
        ]);

        return response()->json([
            'message' => 'Post liked.',
            'likes_count' => $post->likes()->count(),
        ], 201);
    }

    public function index(Post $post)
    {
        $likes = $post->likes()
            ->with('user:id,name,username,email')
            ->latest()
            ->get();

        return response()->json([
            'likes_count' => $likes->count(),
            'users' => $likes->pluck('user'),
        ]);
    }
}
