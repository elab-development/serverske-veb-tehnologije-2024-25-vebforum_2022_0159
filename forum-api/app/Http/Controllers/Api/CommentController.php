<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

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
        if ($request->user()->id !== $comment->user_id && $request->user()->role !== 'moderator') {
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
        if ($request->user()->id !== $comment->user_id && $request->user()->role !== 'moderator') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully.']);
    }
}