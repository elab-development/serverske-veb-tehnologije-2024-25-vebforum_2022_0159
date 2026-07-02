<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function statistics(Request $request)
    {
        if (!$request->user()->isAdmin()) {
            return response()->json([
                'message' => 'Forbidden'
            ], 403);
        }

        $mostLikedPost = Post::withCount('likes')
            ->with('user:id,name,username')
            ->orderByDesc('likes_count')
            ->first();

        return response()->json([
            'users_count' => User::count(),
            'admins_count' => User::where('role', 'admin')->count(),
            'moderators_count' => User::where('role', 'moderator')->count(),
            'topics_count' => Topic::count(),
            'posts_count' => Post::count(),
            'comments_count' => Comment::count(),
            'attachments_count' => Attachment::count(),
            'likes_count' => Like::count(),
            'most_liked_post' => $mostLikedPost,
        ]);
    }
}