<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CommentController extends Controller
{
    public function index(Post $post)
    {
        $comments = $post->comments()
            ->with('user')
            ->latest()
            ->paginate(10);

        return response()->json($comments);
    }

    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
            'content' => 'required|string',
        ]);

        //API

        $response = Http::get('https://www.purgomalum.com/service/containsprofanity', [
            'text' => $data['content'],
        ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'Profanity check service is unavailable.'
            ], 503);
        }

        if ($response->body() === 'true') {
            return response()->json([
                'message' => 'Content contains inappropriate language.'
            ], 422);
        }

        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => $request->user()->id,
            'content' => $data['content'],
        ]);

        return response()->json($comment, 201);
    }

    public function show(Comment $comment)
    {
        return response()->json(
            $comment->load(['user', 'post'])
        );
    }

    public function update(Request $request, Comment $comment)
    {
        if (
            $request->user()->id !== $comment->user_id &&
            !$request->user()->isModerator() &&
            !$request->user()->isAdmin()
        ) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $data = $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update($data);

        return response()->json($comment);
    }

    public function destroy(Request $request, Comment $comment)
    {
        if (
            $request->user()->id !== $comment->user_id &&
            !$request->user()->isModerator() &&
            !$request->user()->isAdmin()
        ) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully.']);
    }
}
